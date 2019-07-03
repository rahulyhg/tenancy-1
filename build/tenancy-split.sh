#!/usr/bin/env bash

git subsplit init git@github.com:tenancy/tenancy.git

# Tenancy.
git subsplit publish --heads="master" src/Tenancy:git@github.com:tenancy/framework.git

# Affects
git subsplit publish --heads="master" src/Affects/Cache:git@github.com:tenancy/affects-cache.git
git subsplit publish --heads="master" src/Affects/Config:git@github.com:tenancy/affects-config.git
git subsplit publish --heads="master" src/Affects/Filesystem:git@github.com:tenancy/affects-filesystem.git
git subsplit publish --heads="master" src/Affects/Logs:git@github.com:tenancy/affects-logs.git
git subsplit publish --heads="master" src/Affects/Models:git@github.com:tenancy/affects-models.git
git subsplit publish --heads="master" src/Affects/Routes:git@github.com:tenancy/affects-routes.git
git subsplit publish --heads="master" src/Affects/URL:git@github.com:tenancy/affects-url.git
git subsplit publish --heads="master" src/Affects/Views:git@github.com:tenancy/affects-views.git

# Lifecycle Hooks
git subsplit publish --heads="master" src/Hooks/Migrations:git@github.com:tenancy/hooks-migrations.git

# Identification drivers
git subsplit publish --heads="master" src/Identification/Console:git@github.com:tenancy/identification-driver-console.git
git subsplit publish --heads="master" src/Identification/Environment:git@github.com:tenancy/identification-driver-environment.git
git subsplit publish --heads="master" src/Identification/Http:git@github.com:tenancy/identification-driver-http.git
git subsplit publish --heads="master" src/Identification/Queue:git@github.com:tenancy/identification-driver-queue.git

# Database drivers
git subsplit publish --heads="master" src/Database/Mysql:git@github.com:tenancy/db-driver-mysql.git
git subsplit publish --heads="master" src/Database/Sqlite:git@github.com:tenancy/db-driver-sqlite.git

# Testing
git subsplit publish --heads="master" src/Testing:git@github.com:tenancy/testing.git

rm -rf .subsplit/
