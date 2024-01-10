package com.weblab.springlab3.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.Errors;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import com.weblab.springlab3.entity.Category;
import com.weblab.springlab3.service.CategoryService;

import jakarta.validation.Valid;

import java.util.List;


@Controller
public class CategoryController {
    @Autowired
    private CategoryService categoryService;

    @GetMapping("/category")
    public String home(Model model) {
        List<Category> categoryList = categoryService.getCategoryList();
        model.addAttribute("categoryList", categoryList);
        return "category/index";
    }

    @GetMapping("/category/add")
    public String add(Model model) {
        model.addAttribute("category", new Category());
        return "/category/add";
    }

    @PostMapping("/category/add")
    public String add(@ModelAttribute @Valid Category category, Errors errors, Model model, RedirectAttributes redirectAttributes) {
        model.addAttribute("category", category);
        if (errors.hasErrors()) {
            return "category/add";
        }
        try {
            categoryService.addCategory(category);
        } catch (IllegalArgumentException e) {
            redirectAttributes.addFlashAttribute("error", e.getMessage());
            return "redirect:/category/add";
        }
        return "redirect:/category";
    }

    @GetMapping("/category/details")
    public String add(@RequestParam("id") long id, Model model) {
        model.addAttribute("category", categoryService.getCategoryById(id));
        return "/category/details";
    }

    @GetMapping(value = {"/category/{categoryId}/edit"})
    public String edit(Model model, @PathVariable long categoryId) {
        model.addAttribute("category", categoryService.getCategoryById(categoryId));
        return "/category/edit";
    }

    @PostMapping(value = {"/category/edit"})
    public String edit(@ModelAttribute @Valid Category category, Errors errors, Model model, RedirectAttributes redirectAttributes) {
        model.addAttribute("category", category);
        if (errors.hasErrors()) {
            return "/category/edit";
        }
        try {
            categoryService.updateCategory(category);
        } catch (IllegalArgumentException e) {
            redirectAttributes.addFlashAttribute("error", e.getMessage());
            return "redirect:/category" + category.getId() + "/edit";
        }
        return "redirect:/category";
    }

    @GetMapping("/category/remove")
    public String remove(@RequestParam("id") long id) {
        categoryService.deleteCategoryById(id);
        return "redirect:/category";
    }
}
