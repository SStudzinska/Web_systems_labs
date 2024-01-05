package com.weblab.springlab1;

import org.springframework.stereotype.Service;

import java.util.ArrayList;

@Service
public class ProductService {
    ArrayList<Product> productList = new ArrayList<>();

    public ProductService() {
        seed();
    }

    public void seed(){
        productList.add(new Product(1, "Milk", 1.5, 5.59, "Diary"));
        productList.add(new Product(2, "Apple", 1.0, 3.20, "Fruit"));
        productList.add(new Product(3, "Cheese", 0.200, 5.19, "Diary"));

    }

    public void addNewProduct(Product product){
        validateProduct(product);
        productList.add(product);
    }


    public Product getProductById(long id) {
        for(Product product:productList){
            if(product.getId()==id)
                return product;
        }
        return null;
    }



    public void updateProduct(Product product){
        for(Product prod : productList){
            if (prod.getId() != product.getId() && prod.getName().equalsIgnoreCase(product.getName())){
                throw new IllegalArgumentException("There's already another product with the name '" + product.getName() + "'!");
            }
        }
        validateProductNameWeightPrice(product);
        Product p = getProductById(product.getId());
        p.setName(product.getName());
        p.setWeight(product.getWeight());
        p.setPrice(product.getPrice());
        p.setCategory(product.getCategory());
    }

    public void deleteProduct(Product product){
        productList.remove(getProductById(product.getId()));
    }

    public void deleteProductById(long id){
        productList.remove(getProductById(id));
    }

    public ArrayList<Product> getProductList() {
        return productList;
    }

    private void validateProduct(Product product){
        if(product.getId() <= 0){
            throw new IllegalArgumentException("Product id cant be less than 0!");
        }
        validateProductNameWeightPrice(product);
        for (Product  p : productList){
            if (p.getId() == product.getId()){
                throw new IllegalArgumentException("Product with id " + p.getId() + " already exists!");
            }
            if (p.getName().equalsIgnoreCase(product.getName())){
                throw new IllegalArgumentException("Product with the name '" + p.getName() + "' already exists!");
            }

        }
    }

    private void validateProductNameWeightPrice(Product product){
        if (product.getName().isBlank()){
            throw new IllegalArgumentException("Product name cant be empty!");
        }
        if (product.getWeight() <= 0){
            throw new IllegalArgumentException("Product weight cant be <= 0");
        }
        if (product.getPrice() <= 0){
            throw new IllegalArgumentException("Product price cant be <= 0");
        }

    }
}
