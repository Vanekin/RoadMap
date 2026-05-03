<?php

namespace RoadMap\Models;

use RoadMap\Core\Database;
use PDO;

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT id, name, surname, email FROM users ORDER BY id DESC");
        return $stmt->fetchAll();
    }
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT id, name, surname, email FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    public function create(string $name, string $surname, string $email, string $password): int
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, surname, email, password_hash) 
                VALUES (:name, :surname, :email, :password_hash)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'password_hash' => $passwordHash
        ]);

        return (int) $this->db->lastInsertId();
    }
    public function verifyPassword(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);

        if ($user && password_verify($password, $user['password_hash'])) {
            // Возвращаем данные без пароля
            return [
                'id' => $user['id'],
                'name' => $user['name'],
                'surname' => $user['surname'],
                'email' => $user['email']
            ];
        }

        return null;
    }
    public function update(int $id, string $name, string $surname, string $email): bool
    {
        $sql = "UPDATE users SET name = :name, surname = :surname, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'surname' => $surname,
            'email' => $email
        ]);
    }
    public function updatePassword(int $id, string $newPassword): bool
    {
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET password_hash = :password_hash WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'password_hash' => $passwordHash
        ]);
    }
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    public function getFullName(int $id): ?string
    {
        $user = $this->find($id);
        if ($user) {
            return $user['name'] . ' ' . $user['surname'];
        }
        return null;
    }
}
