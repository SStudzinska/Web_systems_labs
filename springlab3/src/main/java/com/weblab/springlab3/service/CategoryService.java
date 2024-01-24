package com.weblab.springlab3.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.weblab.springlab3.entity.Category;
import com.weblab.springlab3.optionModel.IdStringModel;
import com.weblab.springlab3.repository.CategoryRepository;

import java.util.ArrayList;
import java.util.List;


@Service
public class CategoryService {
    private CategoryRepository categoryRepository;
    private ProductService productService;

    @Autowired
    public CategoryService(CategoryRepository categoryRepository, ProductService productService) {
        this.categoryRepository = categoryRepository;
        this.productService = productService;
        seed();
    }

    public void seed() {
        categoryRepository.save(
            Category.builder()
                    .id(1)
                    .name("Diary")
                    .code("K1")
                    .build()
        );
        categoryRepository.save(
            Category.builder()
                    .id(2)
                    .name("Fruit")
                    .code("K2")
                    .build()
        );
        categoryRepository.save(
            Category.builder()
                    .id(3)
                    .name("Vegetable")
                    .code("K3")
                    .build()
        );
    }

    public List<Category> getCategoryList() {
        return categoryRepository.findAll();
    }

    public List<IdStringModel> getCategories() {
        List<IdStringModel> categories = new ArrayList<>();
        for (Category cat : getCategoryList()) {
            categories.add(new IdStringModel(cat.getId(), cat.getName()));
        }
        return categories;
    }

    public Category getCategoryById(long id) {
        return categoryRepository.findById(id).orElse(null);
    }

    public Category addCategory(Category category) {
        if (!isNameUnique(category)) {
            throw new IllegalArgumentException("A category with this name already exists");
        }
        if (!isCodeUnique(category)) {
            throw new IllegalArgumentException("A category with this code already exists");
        }
        return categoryRepository.save(category);
    }

    public Category updateCategory(Category category) {
        if (!isNameUnique(category)) {
            throw new IllegalArgumentException("A category with this name already exists");
        }
        if (!isCodeUnique(category)) {
            throw new IllegalArgumentException("A category with this code already exists");
        }
        return categoryRepository.save(category);
    }

    public void deleteCategory(Category category) {
        deleteCategoryById(category.getId());
    }

    public void deleteCategoryById(long id) {
        for (var prod : productService.getProductList()) {
            if (prod.getCategory() == null) {
                continue;
            } if (prod.getCategory().getId() == id) {
                productService.deleteProduct(prod);
            }
        }
        categoryRepository.deleteById(id);
    }

    public boolean isNameUnique(Category category) {
        for (Category cat : categoryRepository.findAll()) {
            if (cat.getName().equals(category.getName()) && cat.getId() != category.getId()) {
                return false;
            }
        }
        return true;
    }

    public boolean isCodeUnique(Category category) {
        for (Category cat : categoryRepository.findAll()) {
            if (cat.getId() != category.getId() && cat.getCode().equals(category.getCode())) {
                return false;
            }
        }
        return true;
    }
}
