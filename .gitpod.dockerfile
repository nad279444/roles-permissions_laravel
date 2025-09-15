FROM gitpod/workspace-php:latest

# Install Node.js (LTS 20.x)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Install SQLite
RUN apt-get install -y sqlite3

# Optional: Install globally useful tools
RUN npm install -g yarn pnpm
