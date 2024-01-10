package com.weblab.springlab2;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import java.util.List;


@Controller
public class CategoryController {
    private final CategoryService categoryService;

    public CategoryController(CategoryService categoryService) {
        this.categoryService = categoryService;
    }

    @GetMapping("/category/")
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
    public String add(@ModelAttribute Category category, BindingResult bindingResult, RedirectAttributes redirectAttributes) {
        if(bindingResult.hasErrors()){
            return "category/add";
        } try {
            categoryService.addNewCategory(category);
        } catch (IllegalArgumentException e) {
            redirectAttributes.addFlashAttribute("error", e.getMessage());
            return "redirect:/category/add";
        }
        return "redirect:/category/";
    }

    @GetMapping("/category/details")
    public String add(@RequestParam("id") long inputId, Model model) {
        model.addAttribute("category", categoryService.getCategoryById(inputId));
        return "/category/details";
    }

    @GetMapping(value = {"/category/{categoryId}/edit"})
    public String edit(Model model, @PathVariable Integer categoryId) {
        model.addAttribute("category", categoryService.getCategoryById(categoryId));
        return "/category/edit";
    }

    @PostMapping(value = {"/category/edit"})
    public String edit(@ModelAttribute Category category, BindingResult bindingResult, RedirectAttributes redirectAttributes) {
        if(bindingResult.hasErrors()){
            return "category/edit";
        } try {
            categoryService.updateCategory(category);
        } catch (IllegalArgumentException e) {
            redirectAttributes.addFlashAttribute("error", e.getMessage());
            return "redirect:/category/" + category.getId() + "/edit";
        }
        return "redirect:/category/";
    }

    @GetMapping("/category/remove")
    public String remove(@RequestParam("id") long id) {
        categoryService.deleteCategoryById(id);
        return "redirect:/category/";
    }
}
