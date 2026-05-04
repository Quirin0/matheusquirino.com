import type { PortfolioProject } from "@/lib/project-types"

/** Usado quando a API não está disponível no build ou no cliente */
export const FALLBACK_PROJECT_LIST: PortfolioProject[] = [
  {
    slug: "e-commerce-platform",
    title: "E-commerce Platform",
    description:
      "Plataforma completa de e-commerce com sistema de pagamentos e gestao de produtos.",
    fullDescription: `Este projeto consiste em uma plataforma de e-commerce completa, desenvolvida com foco em performance e experiencia do usuario.

A aplicacao conta com um sistema robusto de gerenciamento de produtos, carrinho de compras, checkout integrado com gateways de pagamento, e um painel administrativo completo para gestao de pedidos e estoque.

Principais funcionalidades implementadas:
- Catalogo de produtos com filtros avancados e busca
- Sistema de autenticacao e perfil de usuario
- Carrinho de compras persistente
- Integracao com Stripe para pagamentos
- Painel administrativo para gestao de produtos e pedidos
- Notificacoes por email transacionais
- Sistema de avaliacoes e reviews`,
    coverImage: "/placeholder.jpg",
    tags: ["Laravel", "React", "MySQL", "Stripe"],
    featured: true,
    order: 1,
    liveUrl: null,
    githubUrl: null,
  },
  {
    slug: "task-manager-app",
    title: "Task Manager App",
    description:
      "Aplicativo de gerenciamento de tarefas com autenticacao e notificacoes em tempo real.",
    fullDescription: `Aplicativo moderno de gerenciamento de tarefas projetado para aumentar a produtividade pessoal e de equipes.

O sistema permite criar, organizar e acompanhar tarefas de forma intuitiva, com suporte a projetos, etiquetas, prazos e colaboracao em tempo real.

Principais funcionalidades implementadas:
- Criacao e organizacao de tarefas por projetos
- Sistema de drag-and-drop para reorganizar tarefas
- Notificacoes push em tempo real
- Colaboracao em equipe com compartilhamento de projetos
- Filtros e busca avancada
- Modo escuro e claro
- Sincronizacao entre dispositivos`,
    coverImage: "/placeholder.jpg",
    tags: ["React", "Node.js", "MongoDB", "Socket.io"],
    featured: true,
    order: 2,
    liveUrl: null,
    githubUrl: null,
  },
  {
    slug: "blog-cms",
    title: "Blog CMS",
    description:
      "Sistema de gerenciamento de conteudo para blogs com editor rich text e SEO.",
    fullDescription: `Sistema de gerenciamento de conteudo (CMS) completo para criacao e administracao de blogs profissionais.

Desenvolvido com foco em simplicidade de uso e otimizacao para mecanismos de busca, oferece todas as ferramentas necessarias para criar e gerenciar um blog de sucesso.

Principais funcionalidades implementadas:
- Editor de texto rico com suporte a markdown
- Gerenciamento de midias e imagens
- Sistema de categorias e tags
- Otimizacao SEO automatica
- Agendamento de publicacoes
- Sistema de comentarios moderados
- Analytics integrado
- Multiplos autores com niveis de permissao`,
    coverImage: "/placeholder.jpg",
    tags: ["PHP", "MySQL", "JavaScript", "TinyMCE"],
    featured: false,
    order: 3,
    liveUrl: null,
    githubUrl: null,
  },
  {
    slug: "api-restful",
    title: "API RESTful",
    description:
      "API robusta para aplicacoes mobile e web com autenticacao JWT e documentacao.",
    fullDescription: `API RESTful completa e bem documentada, projetada para servir como backend para aplicacoes mobile e web.

Construida seguindo as melhores praticas de desenvolvimento de APIs, com foco em seguranca, escalabilidade e facilidade de uso.

Principais funcionalidades implementadas:
- Autenticacao JWT com refresh tokens
- Rate limiting e protecao contra ataques
- Versionamento de API
- Documentacao interativa com Swagger
- Cache inteligente com Redis
- Logs e monitoramento
- Testes automatizados com cobertura completa
- Deploy automatizado com Docker`,
    coverImage: "/placeholder.jpg",
    tags: ["Laravel", "Docker", "Redis", "Swagger"],
    featured: false,
    order: 4,
    liveUrl: null,
    githubUrl: null,
  },
]

export const FALLBACK_SLUGS = FALLBACK_PROJECT_LIST.map((p) => p.slug)
