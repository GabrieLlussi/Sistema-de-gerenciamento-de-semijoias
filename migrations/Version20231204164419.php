<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204164419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carrinho (id INT AUTO_INCREMENT NOT NULL, id_usuario_id INT DEFAULT NULL, status LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_A731E3C07EB2C349 (id_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carrinho_produto (id INT AUTO_INCREMENT NOT NULL, id_produto_id INT DEFAULT NULL, id_carrinho_id INT DEFAULT NULL, quantidade INT NOT NULL, vendas INT DEFAULT NULL, INDEX IDX_6D2BC499B5D67D81 (id_produto_id), INDEX IDX_6D2BC499CB713E35 (id_carrinho_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carrinho_produto_vendido (id INT AUTO_INCREMENT NOT NULL, produto_id INT NOT NULL, carrinho_id INT DEFAULT NULL, quantidade INT NOT NULL, INDEX IDX_332D9C0D105CFD56 (produto_id), INDEX IDX_332D9C0DD363F3C2 (carrinho_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE log_produto (id INT AUTO_INCREMENT NOT NULL, produto_id INT DEFAULT NULL, categoria_id INT DEFAULT NULL, acao VARCHAR(255) DEFAULT NULL, nome_produto VARCHAR(50) DEFAULT NULL, valor_produto DOUBLE PRECISION DEFAULT NULL, quantidade_produto INT DEFAULT NULL, data DATETIME DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, INDEX IDX_64617140105CFD56 (produto_id), INDEX IDX_646171403397707A (categoria_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE log_vendas (id INT AUTO_INCREMENT NOT NULL, id_carrinho_id INT DEFAULT NULL, numero_carrinho INT DEFAULT NULL, data DATETIME DEFAULT NULL, INDEX IDX_95C7D4CCB713E35 (id_carrinho_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE log_vendas_item (id INT AUTO_INCREMENT NOT NULL, log_venda_id INT DEFAULT NULL, id_produto_id INT DEFAULT NULL, quantidade INT DEFAULT NULL, valor DOUBLE PRECISION DEFAULT NULL, INDEX IDX_F20CF491FC16DC00 (log_venda_id), INDEX IDX_F20CF491B5D67D81 (id_produto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produto (id INT AUTO_INCREMENT NOT NULL, categoria_id INT NOT NULL, nome VARCHAR(255) NOT NULL, descricao VARCHAR(255) NOT NULL, valor DOUBLE PRECISION NOT NULL, quantidade INT NOT NULL, img MEDIUMTEXT DEFAULT NULL, status VARCHAR(15) DEFAULT NULL, INDEX IDX_5CAC49D73397707A (categoria_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regiao (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(25) NOT NULL, descricao VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, regiao_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nome VARCHAR(255) NOT NULL, cpf VARCHAR(255) NOT NULL, telefone VARCHAR(255) NOT NULL, endereco VARCHAR(255) NOT NULL, comissao DOUBLE PRECISION DEFAULT NULL, limite INT DEFAULT NULL, estado_atual VARCHAR(25) DEFAULT NULL, UNIQUE INDEX UNIQ_2265B05DE7927C74 (email), INDEX IDX_2265B05D9FAAD851 (regiao_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE carrinho ADD CONSTRAINT FK_A731E3C07EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE carrinho_produto ADD CONSTRAINT FK_6D2BC499B5D67D81 FOREIGN KEY (id_produto_id) REFERENCES produto (id)');
        $this->addSql('ALTER TABLE carrinho_produto ADD CONSTRAINT FK_6D2BC499CB713E35 FOREIGN KEY (id_carrinho_id) REFERENCES carrinho (id)');
        $this->addSql('ALTER TABLE carrinho_produto_vendido ADD CONSTRAINT FK_332D9C0D105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id)');
        $this->addSql('ALTER TABLE carrinho_produto_vendido ADD CONSTRAINT FK_332D9C0DD363F3C2 FOREIGN KEY (carrinho_id) REFERENCES carrinho (id)');
        $this->addSql('ALTER TABLE log_produto ADD CONSTRAINT FK_64617140105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id)');
        $this->addSql('ALTER TABLE log_produto ADD CONSTRAINT FK_646171403397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('ALTER TABLE log_vendas ADD CONSTRAINT FK_95C7D4CCB713E35 FOREIGN KEY (id_carrinho_id) REFERENCES carrinho (id)');
        $this->addSql('ALTER TABLE log_vendas_item ADD CONSTRAINT FK_F20CF491FC16DC00 FOREIGN KEY (log_venda_id) REFERENCES log_vendas (id)');
        $this->addSql('ALTER TABLE log_vendas_item ADD CONSTRAINT FK_F20CF491B5D67D81 FOREIGN KEY (id_produto_id) REFERENCES produto (id)');
        $this->addSql('ALTER TABLE produto ADD CONSTRAINT FK_5CAC49D73397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05D9FAAD851 FOREIGN KEY (regiao_id) REFERENCES regiao (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carrinho DROP FOREIGN KEY FK_A731E3C07EB2C349');
        $this->addSql('ALTER TABLE carrinho_produto DROP FOREIGN KEY FK_6D2BC499B5D67D81');
        $this->addSql('ALTER TABLE carrinho_produto DROP FOREIGN KEY FK_6D2BC499CB713E35');
        $this->addSql('ALTER TABLE carrinho_produto_vendido DROP FOREIGN KEY FK_332D9C0D105CFD56');
        $this->addSql('ALTER TABLE carrinho_produto_vendido DROP FOREIGN KEY FK_332D9C0DD363F3C2');
        $this->addSql('ALTER TABLE log_produto DROP FOREIGN KEY FK_64617140105CFD56');
        $this->addSql('ALTER TABLE log_produto DROP FOREIGN KEY FK_646171403397707A');
        $this->addSql('ALTER TABLE log_vendas DROP FOREIGN KEY FK_95C7D4CCB713E35');
        $this->addSql('ALTER TABLE log_vendas_item DROP FOREIGN KEY FK_F20CF491FC16DC00');
        $this->addSql('ALTER TABLE log_vendas_item DROP FOREIGN KEY FK_F20CF491B5D67D81');
        $this->addSql('ALTER TABLE produto DROP FOREIGN KEY FK_5CAC49D73397707A');
        $this->addSql('ALTER TABLE usuario DROP FOREIGN KEY FK_2265B05D9FAAD851');
        $this->addSql('DROP TABLE carrinho');
        $this->addSql('DROP TABLE carrinho_produto');
        $this->addSql('DROP TABLE carrinho_produto_vendido');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE log_produto');
        $this->addSql('DROP TABLE log_vendas');
        $this->addSql('DROP TABLE log_vendas_item');
        $this->addSql('DROP TABLE produto');
        $this->addSql('DROP TABLE regiao');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
