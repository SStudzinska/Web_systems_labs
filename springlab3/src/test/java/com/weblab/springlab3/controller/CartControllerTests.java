package com.weblab.springlab3.controller;

import com.weblab.springlab3.controller.CartController;
import com.weblab.springlab3.entity.Cart;

import com.weblab.springlab3.service.CartService;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.mockito.InjectMocks;
import org.mockito.Mock;
import org.mockito.MockitoAnnotations;
import org.springframework.ui.Model;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.mockito.Mockito.*;

import java.util.ArrayList;

public class CartControllerTests {

    @InjectMocks
    CartController cartController;

    @Mock
    CartService cartService;

    @Mock
    Cart cart;

    @Mock
    Model model;

    @BeforeEach
    public void init() {
        MockitoAnnotations.openMocks(this);
    }

    @Test
    public void testShowProductsInCart() {
        String view = cartController.showProductsInCart(model);

        verify(cartService, times(1)).getCartProducts();
        verify(model, times(1)).addAttribute("productsInCart", new ArrayList<>(cart.getProductsInCart()));
        verify(model, times(1)).addAttribute("totalPrice", cartService.calculateTotalPrice());
        
        assertEquals("user/cart/index", view);
    }
}