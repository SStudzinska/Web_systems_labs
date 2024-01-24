package com.weblab.springlab3.service;

import com.weblab.springlab3.entity.Account;
import com.weblab.springlab3.entity.Cart;
import com.weblab.springlab3.entity.Product;
import com.weblab.springlab3.entity.ProductInCart;
import com.weblab.springlab3.repository.AccountRepository;
import com.weblab.springlab3.repository.CartRepository;
import com.weblab.springlab3.repository.ProductInCartRepository;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.mockito.InjectMocks;
import org.mockito.Mock;
import org.mockito.MockitoAnnotations;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContext;
import org.springframework.security.core.context.SecurityContextHolder;

import java.util.HashSet;
import java.util.Optional;

import static org.junit.jupiter.api.Assertions.*;
import static org.mockito.ArgumentMatchers.any;
import static org.mockito.Mockito.*;


class CartServiceTest {
    @Mock
    private CartRepository cartRepository;

    @Mock
    private AccountRepository accountRepository;

    @Mock
    private ProductInCartRepository productInCartRepository;

    @InjectMocks
    private CartService cartService;

    @BeforeEach
    void setUp() {
        MockitoAnnotations.openMocks(this);
    }

    @Test
    void testGetCurrentUserCart() {
        // Mock account and cart
        Account account = new Account();
        account.setId(1L);
        account.setUsername("testUser");
        Cart cart = new Cart(1L, account, new HashSet<>());

        //Mock authentication
        Authentication authentication = new UsernamePasswordAuthenticationToken("testUser", "pwd");

        SecurityContext securityContext = mock(SecurityContext.class);
        when(securityContext.getAuthentication()).thenReturn(authentication);

        SecurityContextHolder.setContext(securityContext);

        when(accountRepository.findByUsername("testUser")).thenReturn(Optional.of(account));
        when(cartRepository.findById(1L)).thenReturn(Optional.of(cart));

        // Run the test
        Cart resultCart = cartService.getCurrentUserCart();

        // Assertions and verifications
        assertNotNull(resultCart);
        assertEquals(cart, resultCart);
        verify(cartRepository, times(1)).findById(1L);
        verify(cartRepository, times(0)).save(any(Cart.class));

        // Reset the authentication
        SecurityContextHolder.clearContext();
    }


    @Test
    void testAddQuantity() {
        ProductInCart productInCart = new ProductInCart(new Product(), 2);
        productInCart.setId(1L);

        when(productInCartRepository.getById(1L)).thenReturn(productInCart);
        when(productInCartRepository.save(any(ProductInCart.class))).thenReturn(productInCart);

        cartService.addQuantity(1L);

        assertNotNull(productInCartRepository.getById(1L));
        assertEquals(3, productInCartRepository.getById(1L).getQuantity());
        verify(productInCartRepository, times(1)).save(any(ProductInCart.class));
    }

}