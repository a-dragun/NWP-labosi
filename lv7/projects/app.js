const mongoose = require('mongoose');
var createError = require('http-errors');
var express = require('express');
var path = require('path');
var cookieParser = require('cookie-parser');
var logger = require('morgan');
const session = require('express-session');

var indexRouter = require('./routes/index');
var usersRouter = require('./routes/users');
var projectsRouter = require('./routes/projects');
var authRouter = require('./routes/auth');

var app = express();

mongoose.connect('mongodb://127.0.0.1:27017/projectsdb', {
  useNewUrlParser: true,
  useUnifiedTopology: true
})
.then(() => console.log('MongoDB connected'))
.catch(err => console.log(err));

app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'ejs');

app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));

app.use(session({
  secret: 'secret_key',
  resave: false,
  saveUninitialized: false
}));

app.use((req, res, next) => {
  res.locals.currentUser = req.session.userId;
  res.locals.username = req.session.username;
  next();
});

app.use('/', indexRouter);
app.use('/users', usersRouter);
app.use('/projects', projectsRouter);
app.use('/auth', authRouter);

app.use((req, res, next) => {
  res.status(404).send('Stranica nije pronađena');
});

app.use((err, req, res, next) => {
  console.error(err.stack);
  res.status(err.status || 500).send('Došlo je do greške na serveru');
});
module.exports = app;
