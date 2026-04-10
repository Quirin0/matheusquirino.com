export const projects = [
  {
    id: "e-commerce-platform",
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
    image: "/images/projects/ecommerce.jpg",
    tags: ["Laravel", "React", "MySQL", "Stripe"],
  },
  {
    id: "task-manager-app",
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
    image: "/images/projects/taskmanager.jpg",
    tags: ["React", "Node.js", "MongoDB", "Socket.io"],
  },
  {
    id: "blog-cms",
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
    image: "/images/projects/blogcms.jpg",
    tags: ["PHP", "MySQL", "JavaScript", "TinyMCE"],
  },
  {
    id: "api-restful",
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
    image: "/images/projects/api.jpg",
    tags: ["Laravel", "Docker", "Redis", "Swagger"],
  },
]

export type Project = (typeof projects)[0]

export function getProjectById(id: string): Project | undefined {
  return projects.find((p) => p.id === id)
}

export function getOtherProjects(currentId: string): Project[] {
  return projects.filter((p) => p.id !== currentId)
}

export function getAllTags(): string[] {
  const tagsSet = new Set<string>()
  projects.forEach((p) => p.tags.forEach((tag) => tagsSet.add(tag)))
  return Array.from(tagsSet).sort()
}
