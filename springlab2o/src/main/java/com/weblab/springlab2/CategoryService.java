package com.weblab.springlab2;

import org.springframework.stereotype.Service;

import java.util.ArrayList;


@Service
public class CategoryService {
    ArrayList<Category> categoryList = new ArrayList<>();

    public CategoryService() {
        seed();
    }

    public void seed() {
        categoryList.add(new Category(1, "Diary", "K1"));
        categoryList.add(new Category(2, "Fruit", "K2"));
        categoryList.add(new Category(3, "Vegetable", "K3"));
    }

    public void addNewCategory(Category category){
        validateCategory(category);
        categoryList.add(category);
    }

    public Category getCategoryById(long id) {
        for (Category category : categoryList) {
            if (category.getId() == id)
                return category;
        }
        return null;
    }

    public void updateCategory(Category category) {
        for(Category cat : categoryList){
            if (cat.getId() != category.getId() && cat.getName().equalsIgnoreCase(category.getName())) {
                throw new IllegalArgumentException("There's already another category with the name '" + category.getName() + "'!");
            }
        }
        validateCategoryNameCode(category);
        Category cat = getCategoryById(category.getId());
        cat.setName(category.getName());
        cat.setCode(category.getCode());
    }

    public void deleteCategory(Category category) {
        categoryList.remove(getCategoryById(category.getId()));
    }

    public void deleteCategoryById(long id) {
        categoryList.remove(getCategoryById(id));
    }

    public ArrayList<Category> getCategoryList() {
        return categoryList;
    }

    private void validateCategory(Category category) {
        if (category.getId() <= 0) {
            throw new IllegalArgumentException("Category id cant be less or equal than 0!");
        }
        validateCategoryNameCode(category);
        for (Category cat : categoryList) {
            if (cat.getId() == category.getId()) {
                throw new IllegalArgumentException("Category with id " + cat.getId() + " already exists!");
            }
            if (cat.getName().equalsIgnoreCase(category.getName())) {
                throw new IllegalArgumentException("There's already another category with the name '" + category.getName() + "'!");
            }
        }
    }

    private void validateCategoryNameCode(Category category){
        if (category.getName().length() < 3) {
            throw new IllegalArgumentException("The name of the category must be at least 3 characters long!");
        }
        if (category.getCode().length() < 2 || category.getCode().length() > 3) {
            throw new IllegalArgumentException("The code of the category must be 2-3 characters long!");
        }
    }

}
