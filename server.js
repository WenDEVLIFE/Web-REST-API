const express = require('express');
const axios = require('axios');
const cors = require('cors');

const app = express();

// Allow CORS from any origin (or specify your frontend URL, e.g., 'http://localhost:3000')
app.use(cors());

// Parse incoming JSON requests
app.use(express.json()); 

// Root route handler
app.get('/', (req, res) => {
  res.send('Welcome to the K-pop Dancers API Proxy!');
});

// Proxy the external API
app.get('/kpop_dancers', async (req, res) => {
  try {
    const response = await axios.get('http://rendel.mooo.com/api/kpop_dancers');
    
    // Clean the response if it contains unexpected characters (e.g., strip out comments)
    const cleanData = response.data.replace(/\/\*.*?\*\//g, ''); // Remove comments
    
    // Parse the cleaned data if necessary (if it's returned as a string)
    const jsonData = JSON.parse(cleanData);

    res.json(jsonData);
  } catch (error) {
    console.error('Error fetching dancers:', error);
    res.status(500).send('Error fetching dancers');
  }
});

app.post('/kpop_dancers', async (req, res) => {
  try {
    console.log("Incoming request body:", req.body); // Log the incoming request body
    const response = await axios.post('http://rendel.mooo.com/api/kpop_dancers', req.body);
    console.log("API response:", response.data); // Log the response from the API
    res.json(response.data);
  } catch (error) {
    console.error('Error creating dancer:', error);
    res.status(500).send('Error creating dancer');
  }
});

app.put('/kpop_dancers/:id', async (req, res) => {
  try {
    const response = await axios.put(`http://rendel.mooo.com/api/kpop_dancers/${req.params.id}`, req.body);
    console.log("API response:", response.data); // Log the response from the API
    res.json(response.data);
  } catch (error) {
    console.error('Error updating dancer:', error);
    res.status(500).send('Error updating dancer');
  }
});

app.delete('/kpop_dancers/:id', async (req, res) => {
  try {
    const response = await axios.delete(`http://rendel.mooo.com/api/kpop_dancers/${req.params.id}`);
    console.log("API response:", response.data); // Log the response from the API
    res.json(response.data);
  } catch (error) {
    console.error('Error deleting dancer:', error);
    res.status(500).send('Error deleting dancer');
  }
});

app.listen(3000, () => {
  console.log('Proxy server running on http://localhost:3000');
});
