package com.springlab3;

import com.weblab.springlab3.service.ProductService;
import com.weblab.springlab3.entity.Product;
import com.weblab.springlab3.repository.ProductRepository;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.mockito.InjectMocks;
import org.mockito.Mock;
import org.mockito.MockitoAnnotations;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.junit.jupiter.api.Assertions.assertNotNull;
import static org.mockito.ArgumentMatchers.any;
import static org.mockito.ArgumentMatchers.anyLong;
import static org.mockito.AdditionalAnswers.returnsFirstArg;
import static org.mockito.Mockito.times;
import static org.mockito.Mockito.verify;
import static org.mockito.Mockito.when;

import java.util.List;
import java.util.Optional;


public class ProductServiceTests {

    @InjectMocks
    ProductService productService;

    @Mock
    ProductRepository productRepository;

    @BeforeEach
    public void init() {
        MockitoAnnotations.openMocks(this);
    }

    @Test
    public void testGetProductList() {
        Product product1 = Product.builder()
                                  .id(1)
                                  .build();
        Product product2 = Product.builder()
                                  .id(2)
                                  .build();

        List<Product> productList = List.of(
            product1,
            product2
        );

        when(productRepository.findAll()).thenReturn(productList);

        List<Product> resultProductList = productService.getProductList();

        assertNotNull(resultProductList);
        assertEquals(2, productList.size());
        assertEquals(productList, resultProductList);

        verify(productRepository, times(1)).findAll();
        verify(productRepository, times(0)).save(product1);
        verify(productRepository, times(0)).save(product2);
    }

    @Test
    public void testGetProductById() {
        Product product = Product.builder()
                                 .id(1)
                                 .build();

        when(productRepository.findById(1L)).thenReturn(
            Optional.of(product)
        );

        Product resultProduct = productService.getProductById(1);

        assertNotNull(product);
        assertEquals(product, resultProduct);

        verify(productRepository, times(1)).findById(anyLong());
        verify(productRepository, times(0)).save(product);
    }

    @Test
    public void testAddProduct() {
        when(productRepository.save(any(Product.class))).then(returnsFirstArg());

        Product product = Product.builder()
                                 .name("Test Product")
                                 .weight(1.0)
                                 .price(100.0)
                                 .build();

        Product resultProduct = productService.addProduct(product);

        assertNotNull(resultProduct);
        assertEquals("Test Product", resultProduct.getName());
        assertEquals(1.0, resultProduct.getWeight());
        assertEquals(100.0, resultProduct.getPrice());
        assertEquals(product, resultProduct);

        verify(productRepository, times(1)).save(product);
    }

    @Test
    public void testUpdateProduct() {
        when(productRepository.save(any(Product.class))).then(returnsFirstArg());

        Product product = Product.builder()
                                 .id(1)
                                 .name("Test Product")
                                 .weight(1.0)
                                 .price(100.0)
                                 .build();
        
        Product resultProduct = productService.updateProduct(product);

        assertNotNull(resultProduct);
        assertEquals("Test Product", resultProduct.getName());
        assertEquals(1.0, resultProduct.getWeight());
        assertEquals(100.0, resultProduct.getPrice());
        assertEquals(product, resultProduct);

        verify(productRepository, times(1)).save(product);
    }

    @Test
    public void testIsNameUnique() {
        when(productRepository.findAll()).thenReturn(
            List.of(
                Product.builder()
                       .id(1)
                       .name("Test Product")
                       .build()
            )
        );

        Product product = Product.builder()
                                 .name("Test Product")
                                 .build();

        assertEquals(false, productService.isNameUnique(product));

        verify(productRepository, times(1)).findAll();
    }
}