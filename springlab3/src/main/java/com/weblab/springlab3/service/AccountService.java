package com.weblab.springlab3.service;

import java.util.List;
import java.util.Objects;
import java.util.Optional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

import com.weblab.springlab3.repository.AccountRepository;
import com.weblab.springlab3.entity.Account;


@Service
public class AccountService implements UserDetailsService {
    private AccountRepository accountRepository;
    public ProductService productService;
    private PasswordEncoder passwordEncoder;

    @Autowired
    public AccountService(
        AccountRepository accountRepository, 
        ProductService productService,
        PasswordEncoder passwordEncoder
    ) {
        this.accountRepository = accountRepository;
        this.productService = productService;
        this.passwordEncoder = passwordEncoder;
        seed();
    }

    public void seed() {
        Account adminAccount = 
            Account.builder()
                .id(1)
                .role(Account.Role.ROLE_ADMIN)
                .username("admin")
                .password(passwordEncoder.encode("admin"))
                .build();
        accountRepository.save(adminAccount);
        Account userAccount = 
            Account.builder()
                .id(2)
                .role(Account.Role.ROLE_USER)
                .username("user")
                .password(passwordEncoder.encode("user"))
                .build();
        accountRepository.save(userAccount);
        Account userAccount2 =
                Account.builder()
                        .id(3)
                        .role(Account.Role.ROLE_USER)
                        .username("user2")
                        .password(passwordEncoder.encode("user2"))
                        .build();
        accountRepository.save(userAccount2);
    }

    public PasswordEncoder getPasswordEncoder() {
        return passwordEncoder;
    }

    public List<Account> getAccountList() {
        return accountRepository.findAll();
    }

    public Account getAccountById(long id) {
        return accountRepository.findById(id).orElse(null);
    }

    public Account getAccountByUsername(String username) {
        return accountRepository.findByUsername(username).orElse(null);
    }

    public Account addAccount(Account account) {
        if (!isUsernameUnique(account)) {
            throw new IllegalArgumentException("An account with this username already exists");
        }
        account.setPassword(passwordEncoder.encode(account.getPassword()));
        account.setRole(Account.Role.ROLE_USER);
        return accountRepository.save(account);
    }

    public Account updateAccount(Account account) {
        if (!isUsernameUnique(account)) {
            throw new IllegalArgumentException("An account with this username already exists");
        }
        return accountRepository.save(account);
    }

    public void deleteAccount(Account account) {
        deleteAccountById(account.getId());
    }

    public void deleteAccountById(long id) {
        accountRepository.deleteById(id);
    }

    public boolean isUsernameUnique(Account account) {
        for (Account acc : getAccountList()) {
            if (acc.getId() != account.getId() && acc.getUsername().equals(account.getUsername())) {
                return false;
            }
        }
        return true;
    }

    public String getUsername(long id) {
        return Objects.requireNonNull(accountRepository.findById(id).orElse(null)).getUsername();
    }

    @Override
    public UserDetails loadUserByUsername(String username) throws UsernameNotFoundException {
        Optional <Account> account = accountRepository.findByUsername(username);
        return account.orElseThrow(() -> new UsernameNotFoundException("User not found"));
    }
}
