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

**A powerful UI + CLI scaffolding tool for generating structured Laravel components using industry best practices.**  
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


---

</div>


## Overview

**Laravel Structure Kit** eliminates the repetitive boilerplate that comes with setting up clean architecture in Laravel. Instead of manually creating files and wiring up interfaces, simply enter a model name, select the components you need, and let the kit scaffold everything — instantly, from a clean browser UI.

It supports the **Service Pattern** and **Repository Pattern** out of the box, making it easy to maintain separation of concerns and write testable, scalable code from day one.

---

## ✨ Features

- 🖥️ **Interactive UI Panel** — a browser-based form to configure and generate files with zero CLI required
- ⚙️ **Selective Component Generation** — choose exactly which files to scaffold (Model, Controller, Service, Repository, Migration)
- 📁 **Customizable File Paths** — override any default namespace or directory before generating
- 🔁 **Service Pattern Support** — generates both the Interface (Contract) and Implementation class
- 🗄️ **Repository Pattern Support** — generates both the Interface (Contract) and Eloquent implementation
- 🚀 **One-Click Generation** — all selected files created in a single action
- 💾 **Path Memory** — optionally remember your custom paths between sessions

---

## Requirements

| Dependency | Version |
|------------|---------|
| PHP        | `^8.1`  |
| Laravel    | `^10.0 \| ^11.0 \| ^12.0 \| ^13.0` |

---

## Installation

Install the package via Composer:

```bash
composer require mehedi250/laravel-structure-kit
```

The package uses Laravel's auto-discovery, so no manual service provider registration is needed.

---

## Usage

### Accessing the UI Panel

After installation, visit the following URL in your browser:

```
http://localhost:8000/structure-kit
```

You'll be presented with the **Laravel Structure Kit** configuration panel.

![Laravel Structure Kit UI](https://raw.githubusercontent.com/mehedi250/laravel-structure-kit/main/src/ui.png)
---

### Step 1 — Enter a Model Name

Type your base model name in the **Base Model Name** field. This name is used to derive all generated file names.

**Example:** `Product` → generates `ProductController.php`, `ProductService.php`, `ProductRepository.php`, etc.

---

### Step 2 — Select Components

Choose which components to generate. All options are selected by default.

| Component            | Description                                                      |
|----------------------|------------------------------------------------------------------|
| **Model**            | Eloquent model class                                             |
| **Controller**       | Resource controller class                                        |
| **Service Pattern**  | Service interface (Contract) + Service implementation class      |
| **Repository Pattern** | Repository interface (Contract) + Eloquent repository class  |
| **Migration**        | Timestamped database migration file                              |

You can deselect any component you don't need using **Deselect All** or by toggling individual checkboxes.

---

### Step 3 — Customize Namespaces (Optional)

Expand the **Customize Namespaces** section to override default file paths before generation.

| Component              | Default Path                          |
|------------------------|---------------------------------------|
| Model                  | `app/Models`                          |
| Controller             | `app/Http/Controllers`                |
| Service Interface      | `app/Services/Contracts`              |
| Service Class          | `app/Services/Implementations`        |
| Repository Interface   | `app/Repositories/Contracts`          |
| Repository Class       | `app/Repositories/Eloquent`           |

If you modify any path, files will be generated in your specified directory instead.

---

### Step 4 — Generate Files

Click the **🚀 Generate Files** button to scaffold all selected components. The **Structure Output** panel on the right will display a live preview of all the files that will be created.

> **Tip:** Check **Remember current path** to persist your custom namespace configuration across sessions.

---

## Example Output

Running the generator with the model name `User` and all components selected produces the following file structure:

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

---

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
