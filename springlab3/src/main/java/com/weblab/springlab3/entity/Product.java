package com.weblab.springlab3.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.Positive;
import lombok.*;


@Entity
@Data
@Builder
@NoArgsConstructor
@AllArgsConstructor
@Table(name = "product")
public class Product {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id", updatable = false, nullable = false)
    private long id;

    @NotBlank(message = "Name must not be empty")
    @Column(name = "name", unique = true, nullable = false)
    private String name;

    @Positive(message = "Weight must be a positive float number")
    @Column(name = "weight", nullable = false)
    private double weight;

    @Positive(message = "Price must be a positive float number")
    @Column(name = "price", nullable = false)
    private double price;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "category_id")
    private Category category;


}
