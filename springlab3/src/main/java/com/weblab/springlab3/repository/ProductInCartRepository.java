package com.weblab.springlab3.repository;

import com.weblab.springlab3.entity.ProductInCart;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface ProductInCartRepository extends JpaRepository<ProductInCart, Long> {
}
