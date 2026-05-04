const fs = require("fs")
const path = require("path")

const src = path.join(__dirname, "out")
const destRoot = path.join(__dirname, "..", "public")

function copyRecursive(srcDir, destDir) {
  if (!fs.existsSync(destDir)) {
    fs.mkdirSync(destDir, { recursive: true })
  }

  const entries = fs.readdirSync(srcDir, { withFileTypes: true })

  for (const entry of entries) {
    const srcPath = path.join(srcDir, entry.name)
    const destPath = path.join(destDir, entry.name)

    if (entry.isDirectory()) {
      copyRecursive(srcPath, destPath)
    } else {
      fs.copyFileSync(srcPath, destPath)
    }
  }
}

function deleteRecursive(dir) {
  if (fs.existsSync(dir)) {
    fs.rmSync(dir, { recursive: true, force: true })
  }
}

const dirsToClear = ["_next", "projetos", "frontend", "_not-found"]
const rootFilesToClear = ["index.html", "404.html", "_not-found.html"]

console.log("Removendo artefatos antigos do Next em public/...")
for (const name of dirsToClear) {
  deleteRecursive(path.join(destRoot, name))
}
for (const name of rootFilesToClear) {
  const p = path.join(destRoot, name)
  if (fs.existsSync(p)) {
    fs.rmSync(p, { recursive: true, force: true })
  }
}

console.log(`Copiando ${src} → ${destRoot}...`)
copyRecursive(src, destRoot)

console.log("Build estático copiado para public/ (URLs sem /frontend).")
