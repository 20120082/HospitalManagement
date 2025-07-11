package com.example.demo.security;

import org.springframework.stereotype.Component;

import com.example.demo.config.EncryptionConfig;

import javax.crypto.Cipher;
import javax.crypto.spec.SecretKeySpec;
import java.util.Base64;

@Component
public class AesEncryptionUtil {

    private final String secretKey;

    public AesEncryptionUtil(EncryptionConfig config) {
        this.secretKey = config.getSecretKey();
    }

    public String encrypt(String value) {
        try {
            SecretKeySpec key = new SecretKeySpec(secretKey.getBytes(), "AES");
            Cipher cipher = Cipher.getInstance("AES");
            cipher.init(Cipher.ENCRYPT_MODE, key);
            byte[] encrypted = cipher.doFinal(value.getBytes());
            return Base64.getEncoder().encodeToString(encrypted);
        } catch (Exception ex) {
            throw new RuntimeException("Mã hoá thất bại", ex);
        }
    }

    public String decrypt(String encryptedValue) {
        try {
            SecretKeySpec key = new SecretKeySpec(secretKey.getBytes(), "AES");
            Cipher cipher = Cipher.getInstance("AES");
            cipher.init(Cipher.DECRYPT_MODE, key);
            byte[] decoded = Base64.getDecoder().decode(encryptedValue);
            byte[] decrypted = cipher.doFinal(decoded);
            return new String(decrypted);
        } catch (Exception ex) {
            throw new RuntimeException("Giải mã thất bại", ex);
        }
    }
}
