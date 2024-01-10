package com.weblab.springlab3.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.weblab.springlab3.entity.Product;
import com.weblab.springlab3.repository.ProductRepository;

import java.util.List;


@Service
public class ProductService {
    private ProductRepository productRepository;

    @Autowired
    public ProductService(ProductRepository productRepository) {
        this.productRepository = productRepository;
        seed();
    }

    public void seed() {
        productRepository.save(
            Product.builder()
                   .id(1)
                   .name("Milk")
                   .weight(1.5)
                   .price(5.59)
                   .build()
        );
        productRepository.save(
            Product.builder()
                   .id(2)
                   .name("Apple")
                   .weight(1.0)
                   .price(3.20)
                   .build()
        );
        productRepository.save(
            Product.builder()
                   .id(3)
                   .name("Cheese")
                   .weight(0.20)
                   .price(5.19)
                   .build()
        );
    }

    public List<Product> getProductList() {
        return productRepository.findAll();
    }

    public Product getProductById(long id) {
        return productRepository.findById(id).orElse(null);
    }

    public void addProduct(Product product) {
        if (!isNameUnique(product)) {
            throw new IllegalArgumentException("A product with this name already exists");
        }
        productRepository.save(product);
    }

    public void updateProduct(Product product) {
        if (!isNameUnique(product)) {
            throw new IllegalArgumentException("A product with this name already exists");
        }
        productRepository.save(product);
    }

    public void deleteProduct(Product product) {
        deleteProductById(product.getId());
    }

    public void deleteProductById(long id) {
        productRepository.deleteById(id);
    }

    public boolean isNameUnique(Product product) {
        for (Product prod : productRepository.findAll()) {
            if (prod.getId() != product.getId() && prod.getName().equals(product.getName())) {
                return false;
            }
        }
        return true;
    }
}
