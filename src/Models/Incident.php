<?php

namespace RoadMap\Models;

use RoadMap\Core\Database;
use PDO;

class Incident
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function getAll(): array
    {
        try {
            $stmt = $this->db->query("SELECT * FROM incidents ORDER BY id DESC");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $this->logger->error('Incident::getAll failed: ' . $e->getMessage());
            throw new DataBaseException("Ошибка при получении списка происшествий", 500, $e);
        }
    }
    public function find(int $id): ?array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM incidents WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch() ?: null;
        } catch (PDOException $e) {
            $this->logger->error('Incident::find failed: ' . $e->getMessage(), ['id' => $id]);
            throw new DataBaseException("Ошибка при поиске происшествия #{$id}", 500, $e);
        }
    }
    public function create(string $title, string $description, float $latitude, float $longitude, string $address): int
    {
        try {
            $sql = "INSERT INTO incidents (title, description, latitude, longitude, adress) 
                    VALUES (:title, :description, :latitude, :longitude, :adress)";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'title' => $title,
                'description' => $description,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'adress' => $address
            ]);

            return (int) $this->db->lastInsertId();
        } catch (PDOException $e) {
            $this->logger->error('Incident::create failed: ' . $e->getMessage(), [
                'title' => $title,
                'adress' => $address
            ]);
            throw new DataBaseException("Ошибка при создании происшествия", 500, $e);
        }
    }
    public function update(int $id, string $title, string $description, string $address): bool
    {
        try {
            $sql = "UPDATE incidents SET title = :title, description = :description, address = :address WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'title' => $title,
                'description' => $description,
                'address' => $address
            ]);
        } catch (PDOException $e) {
            $this->logger->error('Incident::update failed: ' . $e->getMessage(), ['id' => $id]);
            throw new DataBaseException("Ошибка при обновлении происшествия #{$id}", 500, $e);
        }
    }
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM incidents WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            $this->logger->error('Incident::delete failed: ' . $e->getMessage(), ['id' => $id]);
            throw new DataBaseException("Ошибка при удалении происшествия #{$id}", 500, $e);
        }
    }
}