# Git Markdown CMS

## Setup
- Create a git (github, gitlab, gitea, whatever) repo (can be privat)
- Copy `app/config.php.example` to `app/config.php` and edit it
- Make sure documentroot points to the public dir
- Finished

## Config

Default Config:
``` php
$CONFIG = [  
    'git_repo' => '',
    'repo_dir' => ROOT.'/data/',
    'git_bin'  => '/bin/git',
    'base_dir' => ROOT,
    'app_dir' => ROOT.'/app',
    'base_url' => 'https://'.$_SERVER['HTTP_HOST'],
];
```

### git_repo

You can set which git-repo should be used. (It will be automatically cloned.)
- You can use https like this: `https://USER:PASS@HOST/path/to/repo.git`
- Or you can use the normal ssh protocl. If you want to use this you have to make sure, the webserver has a functioning ssh-key. (untested)

### repo_dir

Where it should put the git-repo data.

### git_bin

Where it can find the git tool. (`/bin/git?? should normaly work.)

### base_dir

The base dir of everything.

### app_dir

The app dir. Let it be.

### base_url

- Can be changed to a specific domain/protocol if needed. 
- Default is https and whatever domain you are on.
- Needed for url generation

## Templating

You can find the templates under `app/template`. Example templates are provided which should show you everything you need to know.

## Data

- In the data repo create folders and files in github markdown format. (The extension `.md` is automatically removed/added.)
- Use meta data to select which pages are in the menu, what the title is and which layout (template file) to use.
  - `title` can be used for example to set the title html-tag
  - If `inmenu` is present and either `yes` or `true` it will be in the menu
  - The field `menu` can overwrite the default name displayed in the menu. If not present it will select either the title if present or the filename.

Here an example:

``` markdown
---
title: Home
inmenu: yes
menu: Home
---

# This is page content

- Lorem
- Ipsum
```


