package com.weblab.springlab3.comparator;
import java.util.Comparator;
import com.weblab.springlab3.entity.ProductInCart;

public class ProductInCartComparator implements Comparator<ProductInCart> {

    @Override
    public int compare(ProductInCart p1, ProductInCart p2) {
        return Long.compare(p1.getId(), p2.getId());
    }
}