package com.weblab.springlab2.controller;


import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;


public class MainController {
    @RequestMapping({"", "/", "/index"})
    public String defaultView(Model model) {
        return "index";
    }
}
