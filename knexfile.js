// knexfile.js

// Ensure dotenv is loaded to access environment variables
require('dotenv').config();

module.exports = {
  development: {
    client: 'mysql2', // Specify the database client
    connection: {
      host: process.env.DB_HOST || '127.0.0.1', // Default to localhost if DB_HOST not set
      port: process.env.DB_PORT || 3306,       // Default MySQL port
      user: process.env.DB_USER || 'root',     // Default user for local dev
      password: process.env.DB_PASSWORD || '', // Default empty password for local dev
      database: process.env.DB_NAME || 'newbend' // Default database name
    },
    migrations: {
      directory: './db/migrations' // Directory where migration files will be stored
    },
    seeds: {
      directory: './db/seeds' // Optional: Directory for seed files (initial data)
    }
  },

  production: {
    client: 'mysql2',
    connection: {
      // For production, always use environment variables for sensitive data
      host: process.env.DB_HOST,
      port: process.env.DB_PORT,
      user: process.env.DB_USER,
      password: process.env.DB_PASSWORD,
      database: process.env.DB_NAME,
      ssl: process.env.DB_SSL ? { rejectUnauthorized: true } : false // Add SSL if your production DB requires it
    },
    migrations: {
      directory: './db/migrations'
    },
    seeds: {
      directory: './db/seeds'
    }
  }
};
