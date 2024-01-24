package com.weblab.springlab3.service;

import com.weblab.springlab3.entity.Account;
import com.weblab.springlab3.entity.Cart;
import com.weblab.springlab3.entity.Product;
import com.weblab.springlab3.entity.ProductInCart;
import com.weblab.springlab3.repository.AccountRepository;
import com.weblab.springlab3.repository.CartRepository;
import com.weblab.springlab3.repository.ProductInCartRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.stereotype.Service;

import java.text.DecimalFormat;
import java.util.*;

@Service
public class CartService {

    private CartRepository cartRepository;
    private ProductInCartRepository productInCartRepository;
    private AccountRepository accountRepository;

    @Autowired
    public CartService(CartRepository cartRepository, ProductInCartRepository productInCartRepository, AccountRepository accountRepository) {
        this.cartRepository = cartRepository;
        this.productInCartRepository = productInCartRepository;
        this.accountRepository = accountRepository;
    }

    public Cart addToCart(Product product, int quantity) {
        // Retrieve the current user's cart or create a new one
        Cart cart = getCurrentUserCart();

        // Check if the product is already in the cart
        Optional<ProductInCart> existingProductInCart = cart.getProductsInCart().stream()
                .filter(p -> p.getProduct().equals(product))
                .findFirst();

        if (existingProductInCart.isPresent()) {
            // If the product is already in the cart, update the quantity
            existingProductInCart.get().setQuantity(existingProductInCart.get().getQuantity() + quantity);
        } else {
            // If the product is not in the cart, add it with the specified quantity
            ProductInCart productInCart = new ProductInCart(product, quantity);
            cart.getProductsInCart().add(productInCart);
            productInCartRepository.save(productInCart);
        }

        // Save the updated cart
        return cartRepository.save(cart);
    }

    public Set<ProductInCart> getCartProducts() {
        // Retrieve the current user's cart
        Cart cart = getCurrentUserCart();
        return cart.getProductsInCart();
    }

    public ProductInCart substractQuantity(Long productId) {
        ProductInCart product = productInCartRepository.getById(productId);
        product.setQuantity(product.getQuantity()-1);
        if (product.getQuantity() <= 0){
            removeFromCart(productId);
        }
        return productInCartRepository.save(product);

    }

    public ProductInCart addQuantity(Long productId){
        ProductInCart product = productInCartRepository.getById(productId);
        product.setQuantity(product.getQuantity()+1);
        return productInCartRepository.save(product);
    }

    public ProductInCart removeFromCart(Long productId) {
        Cart cart =  getCurrentUserCart();
        ProductInCart product = productInCartRepository.getById(productId);
        cart.getProductsInCart().removeIf(p -> p.equals(product));
        return productInCartRepository.save(product);
    }

    public String calculateTotalPrice() {
        Cart cart = getCurrentUserCart();

        double totalPrice = cart.getProductsInCart().stream()
                .mapToDouble(productInCart -> {
                    double price = productInCart.getProduct().getPrice();
                    int quantity = productInCart.getQuantity();
                    return price * quantity;
                })
                .sum();

        DecimalFormat decimalFormat = new DecimalFormat("#0.00");
        return decimalFormat.format(totalPrice);
    }

    public Cart getCurrentUserCart() {
        // Get the authentication object
        Authentication authentication = SecurityContextHolder.getContext().getAuthentication();
        //if (authentication != null) {
        if (authentication.isAuthenticated()) {
            // Retrieve the username (assuming it's the user's ID in this example)
            String username = authentication.getName();
            Account account = accountRepository.findByUsername(username).orElse(null);

            return cartRepository.findById(account.getId()).orElseGet(() -> {
                Cart newCart = new Cart(account.getId(), account, new LinkedHashSet<>());
                return cartRepository.save(newCart);
            });
        } else {
            return null;
        }
    }
}
