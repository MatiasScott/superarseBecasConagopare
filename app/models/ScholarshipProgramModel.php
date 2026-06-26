<?php
require_once 'BaseModel.php';

class ScholarshipProgramModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->ensureTable();
        // Carga base histórica y luego sincroniza lo ya registrado en estudiantes.
        $this->seedFromLegacyDefaults();
        $this->seedFromStudents();
    }

    private function ensureTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS scholarship_programs (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL UNIQUE,
                    scholarship_percentage DECIMAL(5,2) NOT NULL DEFAULT 20.00,
                    is_active TINYINT(1) NOT NULL DEFAULT 1,
                    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $this->db->exec($sql);
    }

    private function seedFromStudents()
    {
        $sql = "SELECT program, scholarship
                FROM students
                WHERE program IS NOT NULL
                  AND TRIM(program) <> ''";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            return 0;
        }

        $programMap = [];
        foreach ($rows as $row) {
            $programName = trim((string)($row['program'] ?? ''));
            if ($programName === '') {
                continue;
            }

            $programMap[$programName] = $this->extractPercentageFromScholarship($row['scholarship'] ?? null);
        }

        if (empty($programMap)) {
            return 0;
        }

        $insertSql = "INSERT INTO scholarship_programs (name, scholarship_percentage)
                      VALUES (:name, :scholarship_percentage)
                      ON DUPLICATE KEY UPDATE scholarship_percentage = VALUES(scholarship_percentage)";
        $insertStmt = $this->db->prepare($insertSql);

        $count = 0;
        foreach ($programMap as $name => $percentage) {
            $insertStmt->execute([
                ':name' => $name,
                ':scholarship_percentage' => $percentage
            ]);
            $count++;
        }

        return $count;
    }

    private function seedFromLegacyDefaults()
    {
        $legacyPrograms = [
            ['name' => 'Técnico Superior en Ventas Estratégicas con IA', 'percentage' => 30],
            ['name' => 'Tecnólogo en Educación Básica', 'percentage' => 20],
            ['name' => 'Tecnología Superior en Enfermería Veterinaria', 'percentage' => 30],
            ['name' => 'Tecnólogo en Producción Animal', 'percentage' => 30],
            ['name' => 'Técnico Superior en Marketing Digital', 'percentage' => 20],
            ['name' => 'Seguridad e Higiene del Trabajo', 'percentage' => 20],
            ['name' => 'Seguridad y Prevención de Riesgos Laborales', 'percentage' => 20],
            ['name' => 'Técnico Superior en Administración', 'percentage' => 20],
            ['name' => 'Tecnología Superior en Topografía', 'percentage' => 30],
            ['name' => 'Tecnólogo en Minería', 'percentage' => 30],
        ];

        $sql = "INSERT IGNORE INTO scholarship_programs (name, scholarship_percentage)
            VALUES (:name, :scholarship_percentage)";
        $stmt = $this->db->prepare($sql);

        foreach ($legacyPrograms as $program) {
            $stmt->execute([
                ':name' => $program['name'],
                ':scholarship_percentage' => $program['percentage']
            ]);
        }
    }

    private function extractPercentageFromScholarship($value)
    {
        if ($value === null) {
            return 20.0;
        }

        $raw = str_replace(',', '.', (string)$value);
        if (preg_match('/(\d+(?:\.\d+)?)/', $raw, $matches)) {
            $percentage = (float)$matches[1];
            if ($percentage >= 0 && $percentage <= 100) {
                return $percentage;
            }
        }

        return 20.0;
    }

    public function getAllPrograms($onlyActive = true)
    {
        $sql = "SELECT id, name, scholarship_percentage, is_active
                FROM scholarship_programs";

        if ($onlyActive) {
            $sql .= " WHERE is_active = 1";
        }

        $sql .= " ORDER BY name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getScholarshipByProgram($programName)
    {
        $sql = "SELECT scholarship_percentage
                FROM scholarship_programs
                WHERE name = :name AND is_active = 1
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $programName, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $percentage = $row ? (float)$row['scholarship_percentage'] : 20.0;

        return $this->formatScholarshipPercentage($percentage);
    }

    public function existsByName($name, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) FROM scholarship_programs WHERE name = :name";
        $params = [':name' => $name];

        if ($excludeId !== null) {
            $sql .= " AND id <> :exclude_id";
            $params[':exclude_id'] = (int)$excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int)$stmt->fetchColumn() > 0;
    }

    public function createProgram($name, $scholarshipPercentage)
    {
        $sql = "INSERT INTO scholarship_programs (name, scholarship_percentage)
                VALUES (:name, :scholarship_percentage)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':scholarship_percentage', $scholarshipPercentage);

        return $stmt->execute();
    }

    public function updateProgram($id, $name, $scholarshipPercentage)
    {
        $sql = "UPDATE scholarship_programs
                SET name = :name,
                    scholarship_percentage = :scholarship_percentage
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':scholarship_percentage', $scholarshipPercentage);

        return $stmt->execute();
    }

    public function updateProgramStatus($id, $isActive)
    {
        $sql = "UPDATE scholarship_programs
                SET is_active = :is_active
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $status = $isActive ? 1 : 0;
        $stmt->bindParam(':is_active', $status, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function formatScholarshipPercentage($percentage)
    {
        $normalized = rtrim(rtrim(number_format((float)$percentage, 2, '.', ''), '0'), '.');
        return $normalized . '%';
    }
}
