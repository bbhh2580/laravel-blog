# Laravel Blog

This is a simple blog application built with Laravel 9.1

## Features

## Laravel 中常用的命令

- php artisan key:generate 生成 App Key
- php artisan make:controller 生成控制器
- php artisan make:model 生成模型
- php artisan make:policy 生成授权策略
- php artisan make:seeder 生成 Seeder 文件
- php artisan migrate 执行迁移
- php artisan migrate:rollback 回滚迁移
- php artisan migrate:refresh 重置数据库
- php artisan db:seed 填充数据库
- php artisan tinker 进入 tinker 环境
- php artisan route:list 查看路由列表

### 简单的 git 命令使用流程

- git init 初始化仓库
- git add . 添加所有文件到暂存区, 或者 git add 文件名
- git commit -m "提交信息" 提交到本地仓库
- git push origin main 推送到远程仓库

- git status 查看当前仓库状态
- git checkout 分支名 切换分支
- git checkout -b 分支名 创建并切换分支
- git merge 分支名 合并分支
- git branch -d 分支名 删除分支
- git branch 查看分支
- git branch 分支名 创建分支
- git clone 仓库地址 克隆远程仓库
- git log 查看提交日志
- git remote add origin 仓库地址 添加远程仓库地址

### 2.12

- 今天使用的命令
    - windows 使用 docker 的同学需要去 docker PHP 容器中的项目根目录下执行命令
    - git checkout main 切换到主分支
    - git merge static-pages 合并 static-pages 分支到主(main)分支
    - git push origin main 推送到远程仓库, 或者 git push
    - composer require laravel/ui:3.4.5 --dev 安装 laravel/ui 包
    - php artisan ui bootstrap 引入 bootstrap 前端框架
    - npm install 安装 npm 依赖
    - npm run watch-poll 监听资源文件变化, 并编译资源文件, Laravel Mix 会自动编译资源文件, 运行这个的时候可能会提示需要安装
      resolve-url-loader 依赖
    - yarn add resolve-url-loader@^5.0.0 --dev 安装 resolve-url-loader 依赖, 安装完成后重新运行 npm run watch-poll
    - git checkout main 切换到主分支
    - git status 查看当前仓库状态
    - git clear -df 因为我们在使用 npm run watch-poll 所以我们切换到主分支的时候需要清除掉编译后的资源文件
    - git merge filling-layout-style 合并 filling-layout-style 分支到主(main)分支
    - git push origin main 推送到远程仓库, 或者 git push
- 因为我们使用了 Sass、NPM、Yarn、Laravel Mix 等工具来构成一套完整的前端工作流, 所以需要安装 Node.js, 安装 Node.js 会自动安装
  npm, 但是我们推荐使用 yarn 代替 npm
- 下载 Node.js 和 yarn
    - Node.js: https://nodejs.org/en/
    - MacOS # Download and install Node.js: brew install node@22
    - Yarn: https://classic.yarnpkg.com/lang/en/docs/install

### 2.13

- 今天运行的命令
    - git checkout main 切换到主分支(你们的有可能是 master 分支)
    - git checkout -b modeling-users 创建并切换 modeling-users 分支
    - php artisan migrate 创建数据库表(在运行这个命令之前, 请确保你的 .env 文件中配置了数据库连接信息,
      并且数据库已经创建)
    - php artisan tinker 进入 tinker 环境
        - App\Models\User::create(['name' => '用户名', 'email' => '邮箱地址', 'password' => bcrypt('你的密码')]);
        - use App\Models\User
        - User::find(1);
        - exit 退出 tinker 环境
    - git checkout main 切换到主分支
    - git merge modeling-users 合并 modeling-users 分支到主(main)分支
    - git push origin main 推送到远程仓库, 或者 git push
    - git branch -b signup 创建并切换 signup 分支
    - 在 signup 开发完成今天的功能之后
    - !!! git add .
    - !!! git commit -m "提交信息"
    - php artisan migrate:refresh 重置数据库(注意: 这个命令会删除数据库中的所有数据, 所以请谨慎使用,
      我们这个地方使用是因为我们需要重置掉数据库中的测试数据)
    - composer require overtrue/laravel-lang:~6.0 安装 Laravel 语言包, 安装完成之后需要去 config/app.php 中修改 '
      locale' => 'zh_CN', 你还可以在 lang/zh_CN 目录下修改语言包中的内容
    - git checkout main 切换到主分支
    - git merge signup 合并 signup 分支到主(main)分支
    - git push origin main 推送到远程仓库, 或者 git push

### 2.14

- 今天运行的命令
    - git checkout main 切换到主分支
    - git checkout -b login-logout 创建并切换到 login-logout 分支
    - php artisan make:controller SessionsController 创建 SessionsController 控制器用于开发登录和退出功能
    - ... 每个小功能开发完成之后要提交代码
    - git add .
    - git commit -m "提交信息"
    - 开发完登录和退出功能以及「记住我」之后, 将代码合并到主分支
    - git checkout main 切换到主分支
    - git merge login-logout 合并 login-logout 分支到主(main)分支
    - git push origin main 推送到远程仓库, 或者 git push
    - git checkout -b user-crud 创建并切换到 user-crud 分支, 开发用户的增删改查功能
    - php artisan make:policy UserPolicy 创建 UserPolicy 授权策略
    - php artisan make:seeder UsersTableSeeder 创建 UsersTableSeeder 填充用户数据
    - 如果你检查你的数据库中的 users 表的 AUTO_INCREMENT 不是从 1 开始的那就可以去执行 ALTER TABLE `users`
      AUTO_INCREMENT = 1; 重置 users 表的自增 ID 为 1
    - php artisan migrate:refresh 重置数据库
    - php artisan db:seed 填充用户数据
    - php artisan migrate:refresh --seed 重置数据库并填充用户数据, 这个命令等同于 php artisan migrate:refresh 和 php
      artisan db:seed 的组合
    - 执行了上面的这个就不需要运行了 php artisan db:seed --class=UsersTableSeeder 执行单个 Seeder 文件
    - ... 记得要在你们的开发分支中执行 git add . 和 git commit -m "提交信息"
    - git checkout main 切换到主分支
    - git merge user-crud 合并 user-crud 分支到主(main)分支
    - git push origin main 推送到远程仓库, 或者 git push

- ⚠️ 我们讲到删除用户功能了, 因为删除用户会涉及到管理员的问题, 所以我们留在下周一讲解!!!


###0217hana
-

