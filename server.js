const express = require('express');
const sqlite3 = require('sqlite3').verbose();
const bodyParser = require('body-parser');
const cors = require('cors');
const app = express();
const db = new sqlite3.Database('./users.db');

app.use(cors());
app.use(bodyParser.json());

db.run(`CREATE TABLE IF NOT EXISTS users (
    id TEXT PRIMARY KEY,
    password TEXT NOT NULL
)`);

app.post('/signup', (req, res) => {
    const { id, password } = req.body;
    db.get('SELECT * FROM users WHERE id = ?', [id], (err, row) => {
        if (row) return res.status(400).json({ message: 'User already exists' });
        db.run('INSERT INTO users (id, password) VALUES (?, ?)', [id, password], err => {
            if (err) return res.status(500).json({ message: 'Error saving user' });
            res.json({ message: 'Sign up successful' });
        });
    });
});

app.post('/login', (req, res) => {
    const { id, password } = req.body;
    db.get('SELECT * FROM users WHERE id = ? AND password = ?', [id, password], (err, row) => {
        if (row) return res.json({ message: 'Login successful' });
        res.status(401).json({ message: 'Invalid credentials' });
    });
});

app.listen(3000, () => console.log('Server running on http://localhost:3000'));