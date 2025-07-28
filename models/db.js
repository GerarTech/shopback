// db/connection.js (or a similar file where you manage your database connection)

// Load environment variables from .env file
require('dotenv').config();

const mysql = require('mysql2/promise'); // Using the promise-based API for async/await

// --- Database Configuration ---
// It's crucial to use environment variables for sensitive information like
// database credentials, especially in production.
// For local development, these values should be in your .env file.
// For deployment, set them directly on your hosting platform.

const dbConfig = {
  host: process.env.DB_HOST || '127.0.0.1', // Default to localhost for development
  port: process.env.DB_PORT ? parseInt(process.env.DB_PORT, 10) : 3306, // Default MySQL port
  user: process.env.DB_USER || 'root',     // Default user for local development
  password: process.env.DB_PASSWORD || '', // Default empty password for local development
  database: process.env.DB_NAME || 'newbend', // Default database name
  waitForConnections: true, // Whether to wait for a connection to become available
  connectionLimit: 10,      // Maximum number of connections in the pool
  queueLimit: 0             // Maximum number of requests the pool will queue
};

// --- Create MySQL Connection Pool ---
// A connection pool is recommended for Node.js applications that interact
// with a database frequently. It manages multiple connections, improving
// performance and resource utilization.
const pool = mysql.createPool(dbConfig);

// --- Test Database Connection (Optional but Recommended) ---
// This function attempts to get a connection from the pool and release it
// immediately to verify that the database credentials are correct.
async function testDbConnection() {
  try {
    const connection = await pool.getConnection();
    console.log('✅ Database connection pool created and tested successfully!');
    connection.release(); // Release the connection back to the pool
  } catch (error) {
    console.error('❌ Failed to connect to the database:', error.message);
    // Exit the process if the database connection fails critically at startup
    process.exit(1);
  }
}

// Call the test function when the module is loaded
testDbConnection();

// --- Export the Connection Pool ---
// Export the pool so other parts of your application can use it to
// execute queries.
module.exports = pool;

/*
  How to use this pool in your application files (e.g., paymentMonitor.js):

  const dbPool = require('./db/connection'); // Adjust path as needed

  async function checkTRXPayments() {
    let connection;
    try {
      connection = await dbPool.getConnection(); // Get a connection from the pool
      const [rows] = await connection.query(
        "SELECT * FROM recharge_transactions WHERE status = 'pending' AND currency = 'TRX'"
      );
      console.log('💲 Checking for payments...');
      // Process your transactions here
      return rows;
    } catch (error) {
      console.error('❌ Error in the main checkTRXPayments function:', error);
      throw error; // Re-throw the error for higher-level handling
    } finally {
      if (connection) {
        connection.release(); // Always release the connection back to the pool
      }
    }
  }

  // Example of how you might call it (e.g., in server.js with setInterval)
  // setInterval(checkTRXPayments, 5000); // Check every 5 seconds
*/
