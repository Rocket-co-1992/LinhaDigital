namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240101000000 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // This method is called to apply the migration
        $this->addSql('CREATE TABLE sites (
            id INT AUTO_INCREMENT NOT NULL,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL,
            owner_user_id INT NOT NULL,
            created_at DATETIME NOT NULL,
            PRIMARY KEY(id)
        )');

        $this->addSql('CREATE TABLE site_settings (
            site_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            favicon VARCHAR(255) DEFAULT NULL,
            recaptcha_keys JSON DEFAULT NULL,
            ga_id VARCHAR(255) DEFAULT NULL,
            seo_meta JSON DEFAULT NULL,
            feedback_auto_publish TINYINT(1) NOT NULL DEFAULT 0,
            demo_duration_default INT NOT NULL DEFAULT 30,
            PRIMARY KEY(site_id),
            FOREIGN KEY (site_id) REFERENCES sites(id) ON DELETE CASCADE
        )');

        $this->addSql('CREATE TABLE pages (
            id INT AUTO_INCREMENT NOT NULL,
            site_id INT NOT NULL,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL,
            is_published TINYINT(1) NOT NULL DEFAULT 0,
            PRIMARY KEY(id),
            FOREIGN KEY (site_id) REFERENCES sites(id) ON DELETE CASCADE
        )');

        $this->addSql('CREATE TABLE module_instances (
            id INT AUTO_INCREMENT NOT NULL,
            page_id INT NOT NULL,
            type VARCHAR(255) NOT NULL,
            config_json JSON DEFAULT NULL,
            position INT NOT NULL,
            created_at DATETIME NOT NULL,
            PRIMARY KEY(id),
            FOREIGN KEY (page_id) REFERENCES pages(id) ON DELETE CASCADE
        )');

        $this->addSql('CREATE TABLE feedback (
            id INT AUTO_INCREMENT NOT NULL,
            site_id INT NOT NULL,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            rating INT NOT NULL,
            comment TEXT DEFAULT NULL,
            date DATETIME NOT NULL,
            is_published TINYINT(1) NOT NULL DEFAULT 0,
            PRIMARY KEY(id),
            FOREIGN KEY (site_id) REFERENCES sites(id) ON DELETE CASCADE
        )');

        $this->addSql('CREATE TABLE demo_instances (
            id INT AUTO_INCREMENT NOT NULL,
            site_id INT NOT NULL,
            slug VARCHAR(255) NOT NULL,
            subdomain VARCHAR(255) NOT NULL,
            include_drafts TINYINT(1) NOT NULL DEFAULT 0,
            created_at DATETIME NOT NULL,
            expires_at DATETIME NOT NULL,
            is_active TINYINT(1) NOT NULL DEFAULT 1,
            PRIMARY KEY(id),
            FOREIGN KEY (site_id) REFERENCES sites(id) ON DELETE CASCADE
        )');

        $this->addSql('CREATE TABLE media (
            id INT AUTO_INCREMENT NOT NULL,
            site_id INT NOT NULL,
            filename VARCHAR(255) NOT NULL,
            path VARCHAR(255) NOT NULL,
            type VARCHAR(255) NOT NULL,
            uploaded_at DATETIME NOT NULL,
            PRIMARY KEY(id),
            FOREIGN KEY (site_id) REFERENCES sites(id) ON DELETE CASCADE
        )');
    }

    public function down(Schema $schema): void
    {
        // This method is called to revert the migration
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE demo_instances');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE module_instances');
        $this->addSql('DROP TABLE pages');
        $this->addSql('DROP TABLE site_settings');
        $this->addSql('DROP TABLE sites');
    }
}