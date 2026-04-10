/** @type {import('next').NextConfig} */
const nextConfig = {
  output: "export",
  basePath: "/frontend",
  assetPrefix: "/frontend",
  typescript: {
    ignoreBuildErrors: true,
  },
  images: {
    unoptimized: true,
  },
}

export default nextConfig
