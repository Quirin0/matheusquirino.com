const fs = require("fs")
const path = require("path")

const src = path.join(__dirname, "out")
const dest = path.join(__dirname, "..", "public", "frontend")

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

console.log(`Limpando ${dest}...`)
deleteRecursive(dest)

console.log(`Copiando ${src} → ${dest}...`)
copyRecursive(src, dest)

console.log("Build copiado com sucesso para public/frontend!")
