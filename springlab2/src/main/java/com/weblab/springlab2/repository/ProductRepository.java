package com.weblab.springlab2.repository;

import org.springframework.data.jpa.repository.JpaRepository;

import com.weblab.springlab2.entity.Product;


public interface ProductRepository extends JpaRepository<Product, Long> {
}
