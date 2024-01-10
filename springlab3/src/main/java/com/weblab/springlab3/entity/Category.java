package com.weblab.springlab3.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.Size;
import lombok.*;


@Entity
@Data
@Builder
@NoArgsConstructor
@AllArgsConstructor
@Table(name = "category")
public class Category {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id", updatable = false, nullable = false)
    private long id;

    @NotBlank(message = "Name must not be empty")
    @Column(name = "name", unique = true, nullable = false)
    private String name;

    @Size(min = 2, max = 3, message = "Code must be 2-3 characters")
    @Column(name = "code", unique = true, nullable = false)
    private String code;
}
