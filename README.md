<div align="center">

<br/>

```
 ██████╗████████╗██████╗ ██╗   ██╗ ██████╗████████╗██╗   ██╗██████╗ ███████╗
██╔════╝╚══██╔══╝██╔══██╗██║   ██║██╔════╝╚══██╔══╝██║   ██║██╔══██╗██╔════╝
╚█████╗    ██║   ██████╔╝██║   ██║██║        ██║   ██║   ██║██████╔╝█████╗  
 ╚═══██╗   ██║   ██╔══██╗██║   ██║██║        ██║   ██║   ██║██╔══██╗██╔══╝  
██████╔╝   ██║   ██║  ██║╚██████╔╝╚██████╗   ██║   ╚██████╔╝██║  ██║███████╗
╚═════╝    ╚═╝   ╚═╝  ╚═╝ ╚═════╝  ╚═════╝   ╚═╝    ╚═════╝ ╚═╝  ╚═╝╚══════╝
```

### **Laravel Structure Kit**

**UI-first architecture generator for Laravel.**  
Design and preview your entire project structure — *before writing a single line of code.*

<br/>

[![Laravel](https://img.shields.io/badge/Laravel-10%2B-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-22C55E?style=for-the-badge)](LICENSE)
[![Stars](https://img.shields.io/github/stars/mehedi250/laravel-structure-kit?style=for-the-badge&color=F59E0B&logo=github)](https://github.com/mehedi250/laravel-structure-kit/stargazers)
[![Issues](https://img.shields.io/github/issues/mehedi250/laravel-structure-kit?style=for-the-badge&color=3B82F6)](https://github.com/mehedi250/laravel-structure-kit/issues)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-A855F7?style=for-the-badge)](https://github.com/mehedi250/laravel-structure-kit/pulls)
[![Packagist Downloads](https://img.shields.io/packagist/dt/mehedi250/laravel-structure-kit?style=for-the-badge&color=06B6D4)](https://packagist.org/packages/mehedi250/laravel-structure-kit)

<br/>

[**Quick Start**](#-installation) · [**UI Generator**](#%EF%B8%8F-generate-file-from-ui) · [**CLI Generator**](#%EF%B8%8F-generate-file-via-artisan-command-optional) · [**Use Cases**](#-use-cases) · [**Contributing**](#-contributing)

<br/>

---

</div>

## 🚀 Why Laravel Structure Kit?

Most Laravel developers write code first, then realize their folder structure is a mess. **Laravel Structure Kit flips that workflow.**

Plan your architecture visually — pick your components, preview the file tree, then generate everything in one click. No more:

- ❌ Namespace collisions from misplaced files
- ❌ Inconsistent folder conventions across your team
- ❌ Manually wiring up service and repository boilerplate

> **Architecture first. Code second.**

<br/>

## ✨ Features

### 🖥️ Visual Architecture Generator

| Feature | Description |
|---|---|
| 🎨 **Visual File Builder** | Select and configure your entire app structure via an intuitive UI |
| ☑️ **Component Checkboxes** | Toggle exactly what you need — no more, no less |
| 🗂️ **Customizable Paths** | Override default folders per-component before generating |
| 👁️ **Live File Preview** | See the full file tree update in real-time as you configure |
| 🔤 **Auto Namespace** | Namespaces are resolved automatically based on your folder paths |

### ⌨️ CLI Generator

| Feature | Description |
|---|---|
| ⚡ **Artisan Command** | Generate files from the terminal with a single command |
| 🏳️ **Flag-Based Selection** | Choose components using short flag letters (`m`, `c`, `s`, `r`, `t`) |
| 🔍 **Dry Run Mode** | Preview what will be generated without touching the filesystem |

### 🧩 Supported Components

```
✅ Model
✅ Controller
✅ Service              → Interface + Implementation
✅ Repository           → Interface + Implementation
✅ Migration
```

<br/>

## 📦 Installation

Install the package via Composer:

```bash
composer require mehedi250/laravel-structure-kit
```

That's it. Laravel's **auto-discovery** will register the service provider automatically. No config publishing required.

> **Requires:** PHP `^8.1` · Laravel `^10.0 | ^11.0 | ^12.0 | ^13.0`

<br/>

## 🖥️ Generate File From UI

### Access the UI

Once installed, open your browser and navigate to:

```
http://your-app-url/structure-kit
```

For local development:

```
http://localhost:8000/structure-kit
```

### UI Preview

![Laravel Structure Kit UI](https://raw.githubusercontent.com/mehedi250/laravel-structure-kit/main/src/ui.png)

<br/>

### 🧭 Workflow

```
  ┌─────────────────────────────────────────────────────────────────────┐
  │                                                                     │
  │   Step 1 ➜  Enter Model / Module name   →   e.g. "User"            │
  │   Step 2 ➜  Select components           →   Model, Service, ...    │
  │   Step 3 ➜  Customize folder paths      →   Override defaults       │
  │   Step 4 ➜  Preview the file tree       →   Live update             │
  │   Step 5 ➜  Click Generate              →   Files created! ✅       │
  │                                                                     │
  └─────────────────────────────────────────────────────────────────────┘
```

**Example output for `User` with all components selected:**

```
app/
 ├── Models/
 │   └── User.php
 ├── Http/
 │   └── Controllers/
 │       └── UserController.php
 ├── Services/
 │   ├── Contracts/
 │   │   └── UserServiceInterface.php
 │   └── Implementations/
 │       └── UserService.php
 └── Repositories/
     ├── Contracts/
     │   └── UserRepositoryInterface.php
     └── Eloquent/
         └── UserRepository.php

database/
 └── migrations/
     └── xxxx_xx_xx_create_users_table.php
```

<br/>

## ⚙️ Generate File Via Artisan Command (Optional)

Prefer the terminal? The Artisan command gives you the same power without leaving your editor.

### Syntax

```bash
php artisan structure-kit {ModelName} {flags}
```

### Flags

| Flag | Component | Generated Files |
|:----:|-----------|-----------------|
| `m` | Model | `Models/User.php` |
| `c` | Controller | `Http/Controllers/UserController.php` |
| `s` | Service | `Services/Contracts/UserServiceInterface.php`<br>`Services/Implementations/UserService.php` |
| `r` | Repository | `Repositories/Contracts/UserRepositoryInterface.php`<br>`Repositories/Eloquent/UserRepository.php` |
| `t` | Migration | `database/migrations/xxxx_create_users_table.php` |

### Examples

**Generate everything:**
```bash
php artisan structure-kit User mcsrt
```

**Only Service + Repository (clean architecture layer):**
```bash
php artisan structure-kit User sr
```

**Model + Controller only:**
```bash
php artisan structure-kit Product mc
```

**Preview without generating (dry run):**
```bash
php artisan structure-kit User mcsr --dry-run
```

<br/>

## 🧪 Use Cases

Laravel Structure Kit fits naturally into a wide range of scenarios:

- 🏗️ **Starting a new Laravel project** — establish a consistent structure from day one
- 🔁 **Refactoring existing apps** — preview clean architecture before touching production code
- 👥 **Team environments** — enforce shared conventions so everyone generates files the same way
- ⚡ **Rapid prototyping** — scaffold a full feature's file structure in seconds
- 🎓 **Learning clean architecture** — see how Interfaces, Services, and Repositories connect

<br/>

## 🤝 Contributing

All contributions are welcome! Whether it's a bug fix, new feature, or documentation improvement.

```bash
# 1. Fork the repository on GitHub
# 2. Clone your fork
git clone https://github.com/YOUR_USERNAME/laravel-structure-kit.git

# 3. Create a feature branch
git checkout -b feature/your-amazing-feature

# 4. Commit your changes
git commit -m "feat: add your amazing feature"

# 5. Push and open a Pull Request
git push origin feature/your-amazing-feature
```

🔗 **Repository:** [github.com/mehedi250/laravel-structure-kit](https://github.com/mehedi250/laravel-structure-kit)

<br/>

## 📊 Project Stats

<div align="center">

[![Stars](https://img.shields.io/github/stars/mehedi250/laravel-structure-kit?style=social)](https://github.com/mehedi250/laravel-structure-kit/stargazers)
[![Forks](https://img.shields.io/github/forks/mehedi250/laravel-structure-kit?style=social)](https://github.com/mehedi250/laravel-structure-kit/network/members)
[![Watchers](https://img.shields.io/github/watchers/mehedi250/laravel-structure-kit?style=social)](https://github.com/mehedi250/laravel-structure-kit/watchers)
[![Packagist](https://img.shields.io/packagist/v/mehedi250/laravel-structure-kit?label=packagist&color=orange)](https://packagist.org/packages/mehedi250/laravel-structure-kit)

</div>

<br/>

## 📜 License

Released under the **MIT License**.  
Copyright © 2026 **Md. Mehedi Hasan Shawon**

See the [LICENSE](LICENSE) file for full details.

<br/>

---

<div align="center">

**If this package saved you time, please consider giving it a ⭐ on GitHub!**

Made with ❤️ for the Laravel community · [Report a Bug](https://github.com/mehedi250/laravel-structure-kit/issues) · [Request a Feature](https://github.com/mehedi250/laravel-structure-kit/issues)

</div>
