<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'slug'             => 'e-commerce-platform',
                'title'            => 'E-commerce Platform',
                'description'      => 'Plataforma completa de e-commerce com sistema de pagamentos e gestao de produtos.',
                'full_description' => "Este projeto consiste em uma plataforma de e-commerce completa, desenvolvida com foco em performance e experiencia do usuario.\n\nA aplicacao conta com um sistema robusto de gerenciamento de produtos, carrinho de compras, checkout integrado com gateways de pagamento, e um painel administrativo completo para gestao de pedidos e estoque.\n\nPrincipais funcionalidades implementadas:\n- Catalogo de produtos com filtros avancados e busca\n- Sistema de autenticacao e perfil de usuario\n- Carrinho de compras persistente\n- Integracao com Stripe para pagamentos\n- Painel administrativo para gestao de produtos e pedidos\n- Notificacoes por email transacionais\n- Sistema de avaliacoes e reviews",
                'image_url'        => null,
                'tags'             => ['Laravel', 'React', 'MySQL', 'Stripe'],
                'featured'         => true,
                'order'            => 1,
            ],
            [
                'slug'             => 'task-manager-app',
                'title'            => 'Task Manager App',
                'description'      => 'Aplicativo de gerenciamento de tarefas com autenticacao e notificacoes em tempo real.',
                'full_description' => "Aplicativo moderno de gerenciamento de tarefas projetado para aumentar a produtividade pessoal e de equipes.\n\nO sistema permite criar, organizar e acompanhar tarefas de forma intuitiva, com suporte a projetos, etiquetas, prazos e colaboracao em tempo real.\n\nPrincipais funcionalidades implementadas:\n- Criacao e organizacao de tarefas por projetos\n- Sistema de drag-and-drop para reorganizar tarefas\n- Notificacoes push em tempo real\n- Colaboracao em equipe com compartilhamento de projetos\n- Filtros e busca avancada\n- Modo escuro e claro\n- Sincronizacao entre dispositivos",
                'image_url'        => null,
                'tags'             => ['React', 'Node.js', 'MongoDB', 'Socket.io'],
                'featured'         => true,
                'order'            => 2,
            ],
            [
                'slug'             => 'blog-cms',
                'title'            => 'Blog CMS',
                'description'      => 'Sistema de gerenciamento de conteudo para blogs com editor rich text e SEO.',
                'full_description' => "Sistema de gerenciamento de conteudo (CMS) completo para criacao e administracao de blogs profissionais.\n\nDesenvolvido com foco em simplicidade de uso e otimizacao para mecanismos de busca, oferece todas as ferramentas necessarias para criar e gerenciar um blog de sucesso.\n\nPrincipais funcionalidades implementadas:\n- Editor de texto rico com suporte a markdown\n- Gerenciamento de midias e imagens\n- Sistema de categorias e tags\n- Otimizacao SEO automatica\n- Agendamento de publicacoes\n- Sistema de comentarios moderados\n- Analytics integrado\n- Multiplos autores com niveis de permissao",
                'image_url'        => null,
                'tags'             => ['PHP', 'MySQL', 'JavaScript', 'TinyMCE'],
                'featured'         => false,
                'order'            => 3,
            ],
            [
                'slug'             => 'api-restful',
                'title'            => 'API RESTful',
                'description'      => 'API robusta para aplicacoes mobile e web com autenticacao JWT e documentacao.',
                'full_description' => "API RESTful completa e bem documentada, projetada para servir como backend para aplicacoes mobile e web.\n\nConstruida seguindo as melhores praticas de desenvolvimento de APIs, com foco em seguranca, escalabilidade e facilidade de uso.\n\nPrincipais funcionalidades implementadas:\n- Autenticacao JWT com refresh tokens\n- Rate limiting e protecao contra ataques\n- Versionamento de API\n- Documentacao interativa com Swagger\n- Cache inteligente com Redis\n- Logs e monitoramento\n- Testes automatizados com cobertura completa\n- Deploy automatizado com Docker",
                'image_url'        => null,
                'tags'             => ['Laravel', 'Docker', 'Redis', 'Swagger'],
                'featured'         => false,
                'order'            => 4,
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(['slug' => $project['slug']], $project);
        }
    }
}
