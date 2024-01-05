package com.weblab.springlab1;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import java.util.List;

@Controller
public class ProductController {
    private final ProductService productService;

    public ProductController(ProductService productService) {
        this.productService = productService;
    }

    @RequestMapping("/")
    public String defaultView(Model model){
        List<Product> productList = productService.getProductList();
        model.addAttribute("productList", productList );
        return "product/index";

    }
    @GetMapping("/product/")
    public String home(Model model) {
        List<Product> productList = productService.getProductList();
        model.addAttribute("productList", productList );
        return "product/index";
    }

    @GetMapping("/product/add")
    public String add(Model model) {
        model.addAttribute("product", new Product() );
        return "product/add";
    }

    @PostMapping("/product/add")
    public String add(@ModelAttribute Product product, BindingResult bindingResult, RedirectAttributes redirectAttributes) {
        if(bindingResult.hasErrors()){
            return "product/add";
        }
        try{
            productService.addNewProduct(product);
        }
        catch (IllegalArgumentException e) {
            redirectAttributes.addFlashAttribute("error", e.getMessage());
            return "redirect:/product/add";
        }

        return "redirect:/product/";
    }

    @GetMapping("/product/details")
    public String add(@RequestParam("id") long inputId, Model model) {
        model.addAttribute("product", productService.getProductById(inputId));
        return "/product/details";
    }


    @GetMapping(value = {"/product/{productId}/edit"})
    public String edit(Model model, @PathVariable Integer productId) {
        model.addAttribute("product", productService.getProductById(productId) );
        return "/product/edit";
    }

    @PostMapping(value = {"/product/edit"})
    public String edit(@ModelAttribute Product product, BindingResult bindingResult, RedirectAttributes redirectAttributes) {
        if(bindingResult.hasErrors()){
            return "product/edit";
        }
        try{
            productService.updateProduct(product);
        }
        catch (IllegalArgumentException e) {
            redirectAttributes.addFlashAttribute("error", e.getMessage());
            return "redirect:/product/" + product.getId() + "/edit";
        }
        return "redirect:/product/";
    }


    @GetMapping("/product/remove")
    public String remove(@RequestParam("id") long id) {
        productService.deleteProductById(id);
        return "redirect:/product/";
    }

}
