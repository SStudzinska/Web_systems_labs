package com.weblab.springlab3.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.Errors;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import com.weblab.springlab3.entity.Product;
import com.weblab.springlab3.service.CategoryService;
import com.weblab.springlab3.service.ProductService;

import jakarta.validation.Valid;

import java.util.List;


@Controller
public class ProductController {
    @Autowired
    private ProductService productService;
    @Autowired
    private CategoryService categoryService;

    @GetMapping("/admin/product")
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
        return "admin/product/index";
    }

    @GetMapping("/admin/product/add")
    public String add(Model model) {
        model.addAttribute("product", new Product());
        model.addAttribute("categories", categoryService.getCategories());
        return "admin/product/add";
    }

    @PostMapping("/admin/product/add")
    public String add(@ModelAttribute @Valid Product product, Errors errors, Model model, RedirectAttributes redirectAttributes) {
        model.addAttribute("product", product);
        if (errors.hasErrors()) {
            return "admin/product/add";
        }
        try {
            productService.addProduct(product);
        } catch (IllegalArgumentException e) {
            redirectAttributes.addFlashAttribute("error", e.getMessage());
            return "redirect:/admin/product/add";
        }
        return "redirect:/admin/product";
    }

    @GetMapping("/admin/product/details")
    public String add(@RequestParam("id") long id, Model model) {
        model.addAttribute("product", productService.getProductById(id));
        return "/admin/product/details";
    }


    @GetMapping(value = {"/admin/product/{productId}/edit"})
    public String edit(Model model, @PathVariable long productId) {
        model.addAttribute("product", productService.getProductById(productId));
        model.addAttribute("categories", categoryService.getCategories());
        return "/admin/product/edit";
    }

    @PostMapping("/admin/product/edit")
    public String edit(@ModelAttribute @Valid Product product, Errors errors, Model model, RedirectAttributes redirectAttributes) {
        model.addAttribute("product", product);
        if (errors.hasErrors()) {
            return "/admin/product/edit";
        }
        try {
            productService.updateProduct(product);
        } catch (IllegalArgumentException e) {
            redirectAttributes.addFlashAttribute("error", e.getMessage());
            return "redirect:/admin/product/" + product.getId() + "/edit";
        }
        return "redirect:/admin/product";
    }

    @GetMapping("/admin/product/remove")
    public String remove(@RequestParam("id") long id) {
        productService.deleteProductById(id);
        return "redirect:/admin/product";
    }
}
