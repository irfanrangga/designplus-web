const express = require('express');
const productRoutes = require('./productRoutes');
const userRoutes = require('./userRoutes');

const router = express.Router();

router.use(productRoutes);
router.use(userRoutes);

module.exports = router;
