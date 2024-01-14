package com.weblab.springlab3.controller;

import com.weblab.springlab3.entity.Product;
import com.weblab.springlab3.service.CartService;
import com.weblab.springlab3.service.ProductService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@Controller
public class CartController {
    @Autowired
    private CartService cartService;
    @Autowired
    private ProductService productService;

    @GetMapping("/user")
    public String homeUser(Model model){
        return "user/index";
    }

    @GetMapping("/user/productView")
    public String productView(Model model) {
        List<Product> productList = productService.getProductList();
        model.addAttribute("productList", productList);
        return "user/productView/index";
    }

    @GetMapping("/user/cart")
    public String showProductsInCart(Model model) {
        String totalPrice = cartService.calculateTotalPrice();
        model.addAttribute("productsInCart", cartService.getCartProducts());
        model.addAttribute("totalPrice", totalPrice);
        return "user/cart/index";
    }

    @GetMapping("/user/{productId}/add")
    public String addToCart(@PathVariable Long productId) {
        // Retrieve the product based on productId
        Product product = productService.getProductById(productId);
        cartService.addToCart(product, 1);

        // Redirect back to the product view
        return "redirect:/user/productView";
    }

    @GetMapping("/user/cart/{productId}/add")
    public String addQuantity(@PathVariable Long productId) {
        cartService.addQuantity(productId);
        return "redirect:/user/cart";
    }

    @GetMapping("/user/cart/{productId}/sub")
    public String substractQuantity(@PathVariable Long productId) {
        cartService.substractQuantity(productId);
        return "redirect:/user/cart";
    }

    @GetMapping("/user/cart/remove")
    public String removeFromCart(@RequestParam("id") long id) {
        cartService.removeFromCart(id);
        return "redirect:/user/cart";
    }


    }

