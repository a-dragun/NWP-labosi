const express = require('express');
const router = express.Router();
const User = require('../models/User');

router.get('/register', (req, res) => {
  res.render('auth/register');
});

router.post('/register', async (req, res) => {
  try {
    const { username, password } = req.body;

    const existingUser = await User.findOne({ username });
    if (existingUser) {
      return res.render('auth/register', { error: 'Korisničko ime već postoji' });
    }

    const user = await User.create({ username, password });
    req.session.userId = user._id;
    req.session.username = user.username;

    res.redirect('/');
  } catch (err) {
    res.render('auth/register', { error: err.message });
  }
});

router.get('/login', (req, res) => {
  res.render('auth/login');
});

router.post('/login', async (req, res) => {
  try {
    const { username, password } = req.body;

    const user = await User.findOne({ username });
    if (!user) {
      return res.render('auth/login', { error: 'Neispravno korisničko ime ili lozinka' });
    }

    const isMatch = await user.comparePassword(password);
    if (!isMatch) {
      return res.render('auth/login', { error: 'Neispravno korisničko ime ili lozinka' });
    }

    req.session.userId = user._id;
    req.session.username = user.username;

    res.redirect('/');
  } catch (err) {
    res.render('auth/login', { error: err.message });
  }
});

router.post('/logout', (req, res) => {
  req.session.destroy(err => {
    if (err) return res.status(500).send('Greška pri odjavi');
    res.redirect('/');
  });
});

module.exports = router;
