package com.weblab.springlab2;

import lombok.*


@Entity
public class Category {
    private long id;
    private String name;
    private String code;

    public Category() {
    }

    public Category(long id, String name, String code) {
        this.id = id;
        this.name = name;
        this.code = code;
    }

    public long getId() { 
        return id; 
    }

    public void setId(long id) { 
        this.id = id; 
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getCode() {
        return code;
    }

    public void setCode(String code) {
        this.code = code;
    }
}
