const express = require('express')
const app = express();
const myRoutes = require('./routes/api.js')

app.set('view engine', 'ejs');
app.set('views', './views');

app.use(express.json());

// Middleware to serve static files
app.use(express.static('public'))

app.use(express.urlencoded({
  extended: false
}))

app.use('/api',myRoutes)

// Send 404 Error Page
app.use((req, res, next) => {
  res.render('404')
})

app.listen(8000, () => {
  console.log('Server is running at http://localhost:8000')
})