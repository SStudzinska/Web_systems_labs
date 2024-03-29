package com.weblab.springlab2.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.Errors;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import com.weblab.springlab2.entity.Product;
import com.weblab.springlab2.service.CategoryService;
import com.weblab.springlab2.service.ProductService;

import jakarta.validation.Valid;

import java.util.List;

@Controller
public class ProductController {
    @Autowired
    private ProductService productService;
    @Autowired
    private CategoryService categoryService;

    @GetMapping("/product")
    public String home(Model model) {
        List<Product> productList = productService.getProductList();
        try {
            Product product1 = productList.get(0);
            Product product2 = productList.get(1);
            Product product3 = productList.get(2);
            
            if (product1.getCategory() == null) {
                product1.setCategory(categoryService.getCategoryList().get(0));
                productService.updateProduct(product1);
            } if (product2.getCategory() == null) {
                product2.setCategory(categoryService.getCategoryList().get(1));
                productService.updateProduct(product2);
            } if (product3.getCategory() == null) {
                product3.setCategory(categoryService.getCategoryList().get(0));
                productService.updateProduct(product3);
            }
        }
        catch (Exception e) {
            {};
        }
        model.addAttribute("productList", productList);
        return "product/index";
    }

    @GetMapping("/product/add")
    public String add(Model model) {
        model.addAttribute("product", new Product());
        model.addAttribute("categories", categoryService.getCategories());
        return "product/add";
    }

    @PostMapping("/product/add")
    public String add(@ModelAttribute @Valid Product product, Errors errors, Model model, RedirectAttributes redirectAttributes) {
        model.addAttribute("product", product);
        if (errors.hasErrors()) {
            return "product/add";
        }
        try {
            productService.addProduct(product);
        } catch (IllegalArgumentException e) {
            redirectAttributes.addFlashAttribute("error", e.getMessage());
            return "redirect:/product/add";
        }
        return "redirect:/product";
    }

    @GetMapping("/product/details")
    public String add(@RequestParam("id") long id, Model model) {
        model.addAttribute("product", productService.getProductById(id));
        return "/product/details";
    }


    @GetMapping(value = {"/product/{productId}/edit"})
    public String edit(Model model, @PathVariable long productId) {
        model.addAttribute("product", productService.getProductById(productId));
        model.addAttribute("categories", categoryService.getCategories());
        return "/product/edit";
    }

    @PostMapping(value = {"/product/edit"})
    public String edit(@ModelAttribute @Valid Product product, Errors errors, Model model, RedirectAttributes redirectAttributes) {
        model.addAttribute("product", product);
        if (errors.hasErrors()) {
            return "/product/edit";
        }
        try {
            productService.updateProduct(product);
        } catch (IllegalArgumentException e) {
            redirectAttributes.addFlashAttribute("error", e.getMessage());
            return "redirect:/product/" + product.getId() + "/edit";
        }
        return "redirect:/product";
    }

    @GetMapping("/product/remove")
    public String remove(@RequestParam("id") long id) {
        productService.deleteProductById(id);
        return "redirect:/product";
    }
}
