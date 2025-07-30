FROM mcr.microsoft.com/devcontainers/php:1-8.1-bullseye

USER vscode
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mkdir -p /home/vscode/.local/bin && mv /home/vscode/.symfony5/bin/symfony /home/vscode/.local/bin
