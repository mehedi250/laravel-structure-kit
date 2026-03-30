# Laravel Structure Kit

![Laravel](https://img.shields.io/badge/Laravel-10%2B-red)
![License](https://img.shields.io/badge/License-MIT-yellow.svg)
![Stars](https://img.shields.io/github/stars/mehedi250/laravel-structure-kit)
![Issues](https://img.shields.io/github/issues/mehedi250/laravel-structure-kit)
![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)

> **UI-first architecture generator for Laravel**
> Design and preview your project structure **before writing code**.

---

## 🚀 Why Laravel Structure Kit?

This package helps you:

* Design architecture **before generating files**
* Maintain a **clean and scalable structure**
* Avoid namespace and folder mistakes
* Enforce **clean architecture patterns**

> **Architecture first. Code second.**

---

## ✨ Features

### 🖥️ UI-Based Architecture Generator

* Visual **file & architecture generator**
* Select components with **checkboxes**
* **Customizable paths** for each component
* **Live preview** of the file structure
* Automatic **namespace generation**

---

### 🧩 Supported Components

* Model
* Controller
* Service *(Interface + Implementation)*
* Repository *(Interface + Implementation)*
* Migration

---

## 📦 Installation

Install via Composer:

```bash
composer require mehedi250/laravel-structure-kit
```

Laravel will automatically discover the service provider.

---

## 🖥️ UI Generator

### Access URL

```
http://your-app-url/structure-kit
```

Example:

```
http://localhost:8000/structure-kit
```

---

## 📸 Screenshot

![Laravel Structure Kit UI](https://raw.githubusercontent.com/mehedi250/laravel-structure-kit/main/src/ui.png)

---

## 🧭 Workflow

1. Enter **Model / Module name**
2. Select components
3. Customize folder paths
4. Preview the file structure
5. Click **Generate**

This will generate something like:
```bash
app/
 ├── Models/User.php
 ├── Http/Controllers/UserController.php
 ├── Services/Contacts/UserServiceInterface.php
 ├── Services/Implementations/UserService.php
 ├── Repositories/Contacts/UserRepositoryInterface.php
 ├── Repositories/Eloquent/UserRepository.php

database/migrations/
 └── create_users_table.php
```
---

## ⚙️ CLI Generator (Optional)

If you prefer not to use the UI, you can generate files directly using an **Artisan command**.

### Command

```bash
php artisan structure-kit ModelName mcsrt
```

| Flag | Description                             |
| ---- | --------------------------------------- |
| m    | Model                                   |
| c    | Controller                              |
| s    | Service (Interface + Implementation)    |
| r    | Repository (Interface + Implementation) |
| t    | Migration                               |


### Examples

Generate everything:

```bash
php artisan structure-kit User mcsrt
```

Generate only service & repository:

```bash
php artisan structure-kit User sr
```

Preview without generating files:

```bash
php artisan structure-kit User mcsr --dry-run
```

---

## 🧪 Use Cases

* New Laravel projects
* Refactoring existing applications
* Enforcing team architecture
* Rapid scaffolding

---

## 🤝 Contributing

Contributions are welcome!

1. Fork the repository
2. Create your feature branch
3. Submit a pull request

🔗 Repository
https://github.com/mehedi250/laravel-structure-kit

### 📊 Project Stats

![Stars](https://img.shields.io/github/stars/mehedi250/laravel-structure-kit?style=social)
![Forks](https://img.shields.io/github/forks/mehedi250/laravel-structure-kit?style=social)
![Issues](https://img.shields.io/github/issues/mehedi250/laravel-structure-kit)

---

## 📜 License

MIT License © 2026 **Md. Mehedi Hasan Shawon**

See the [LICENSE](LICENSE) file for details.

![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)

---

⭐ If you like this project, consider **giving it a star on GitHub**.
