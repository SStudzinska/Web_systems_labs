package com.springlab3;

import com.weblab.springlab3.entity.Account;
import com.weblab.springlab3.entity.Cart;
import com.weblab.springlab3.entity.Product;
import com.weblab.springlab3.entity.ProductInCart;
import com.weblab.springlab3.repository.AccountRepository;
import com.weblab.springlab3.repository.CartRepository;
import com.weblab.springlab3.repository.ProductInCartRepository;
import com.weblab.springlab3.service.CartService;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.mockito.InjectMocks;
import org.mockito.Mock;
import org.mockito.MockitoAnnotations;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.GrantedAuthority;
import org.springframework.security.core.authority.SimpleGrantedAuthority;
import org.springframework.security.core.context.SecurityContext;
import org.springframework.security.core.context.SecurityContextHolder;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.junit.jupiter.api.Assertions.assertNotNull;
import static org.mockito.ArgumentMatchers.any;
import static org.mockito.ArgumentMatchers.anyLong;
import static org.mockito.Mockito.*;

import java.util.ArrayList;
import java.util.List;
import java.util.Optional;
import java.util.Set;


public class CartServiceTests {

    @InjectMocks
    CartService cartService;

    @Mock
    CartRepository cartRepository;

    @Mock
    AccountRepository accountRepository;

    @Mock
    ProductInCartRepository productInCartRepository;

    @Mock
    SecurityContext securityContext;

    Account account;

    @BeforeEach
    public void init() {
        MockitoAnnotations.openMocks(this);

        // Mock user authentication
        List<GrantedAuthority> authorities = new ArrayList<>();
        authorities.add(new SimpleGrantedAuthority("USER"));
        Authentication authentication = new UsernamePasswordAuthenticationToken("user", "password", authorities);
        when(securityContext.getAuthentication()).thenReturn(authentication);
        SecurityContextHolder.setContext(securityContext);

        Account account = Account.builder()
                                 .id(1)
                                 .username("user")
                                 .build();

        when(accountRepository.findByUsername("user")).thenReturn(
            Optional.of(account)
        );
    }

    @Test
    public void testGetCurrentUserCart() {
        Cart cart = Cart.builder()
                        .id(1L)
                        .account(account)
                        .build();

        when(cartRepository.findById(1L)).thenReturn(
            Optional.of(cart)
        );

        Cart resultCart = cartService.getCurrentUserCart();

        assertNotNull(resultCart);
        assertEquals(cart, resultCart);

        verify(cartRepository, times(1)).findById(anyLong());
        verify(cartRepository, times(0)).save(any(Cart.class));
    }

    @Test
    public void testGetCartProducts() {
        Set<ProductInCart> products = Set.of(
            ProductInCart.builder()
                         .id(1)
                         .build(),
            ProductInCart.builder()
                         .id(2)
                         .build()
        );

        Cart cart = Cart.builder()
                        .id(1L)
                        .account(account)
                        .productsInCart(products)
                        .build();

        when(cartRepository.findById(1L)).thenReturn(
            Optional.of(cart)
        );

        Set<ProductInCart> resultProductsInCart = cartService.getCartProducts();

        assertNotNull(resultProductsInCart);
        assertEquals(2, resultProductsInCart.size());
        assertEquals(products, resultProductsInCart);

        verify(cartRepository, times(1)).findById(anyLong());
        verify(cartRepository, times(0)).save(any(Cart.class));
    }

    @Test
    void testAddQuantity() {
        ProductInCart productInCart = ProductInCart.builder()
                                                   .id(1L)
                                                   .quantity(2)
                                                   .build();

        when(productInCartRepository.getById(1L)).thenReturn(productInCart);
        when(productInCartRepository.save(any(ProductInCart.class))).thenReturn(productInCart);

        cartService.addQuantity(1L);

        assertNotNull(productInCartRepository.getById(1L));
        assertEquals(3, productInCartRepository.getById(1L).getQuantity());
        
        verify(productInCartRepository, times(1)).save(any(ProductInCart.class));
    }
}