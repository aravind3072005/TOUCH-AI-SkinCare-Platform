import { useState, useEffect, useMemo } from 'react';

const SkincareProductsCatalog = ({ 
  // Props to integrate with your project
  primaryColor = '#667eea',
  secondaryColor = '#764ba2',
  accentColor = '#28a745',
  backgroundColor = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
  onProductSelect = null,
  showAddToCart = true,
  showWishlist = true,
  userSkinType = null
}) => {
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedCategory, setSelectedCategory] = useState('all');
  const [selectedSkinType, setSelectedSkinType] = useState('all');
  const [selectedBrand, setSelectedBrand] = useState('all');
  const [sortBy, setSortBy] = useState('popularity');
  const [priceRange, setPriceRange] = useState([0, 200]);
  const [wishlist, setWishlist] = useState([]);
  const [cart, setCart] = useState([]);

  // Comprehensive skincare products database
  const products = [
    // Cleansers
    {
      id: 1,
      name: "Gentle Hydrating Cleanser",
      brand: "CeraVe",
      category: "cleanser",
      price: 24.99,
      originalPrice: 29.99,
      rating: 4.8,
      reviews: 2847,
      skinTypes: ["normal", "dry", "sensitive"],
      description: "A gentle, non-foaming cleanser that removes makeup and dirt while maintaining the skin's natural protective barrier.",
      ingredients: ["Ceramides", "Hyaluronic Acid", "MVE Technology"],
      benefits: ["Hydrates", "Gentle Cleansing", "Barrier Repair"],
      image: "https://images.unsplash.com/photo-1556228720-195a672e8a03?w=300&h=200&fit=crop",
      bestseller: true,
      newArrival: false,
      onSale: true
    },
    {
      id: 2,
      name: "Foaming Oil Cleanser",
      brand: "Tatcha",
      category: "cleanser",
      price: 48.00,
      originalPrice: 48.00,
      rating: 4.6,
      reviews: 1523,
      skinTypes: ["oily", "acne", "normal"],
      description: "Japanese botanical oils dissolve makeup and impurities while green tea provides antioxidant protection.",
      ingredients: ["Camellia Oil", "Green Tea", "Rice Bran"],
      benefits: ["Deep Cleansing", "Antioxidant Protection", "Makeup Removal"],
      image: "https://images.unsplash.com/photo-1570554886111-e80fcac6c36b?w=300&h=200&fit=crop",
      bestseller: false,
      newArrival: true,
      onSale: false
    },
    {
      id: 3,
      name: "Salicylic Acid Cleanser",
      brand: "Paula's Choice",
      category: "cleanser",
      price: 32.00,
      originalPrice: 32.00,
      rating: 4.7,
      reviews: 3241,
      skinTypes: ["oily", "acne"],
      description: "Beta hydroxy acid cleanser that unclogs pores and reduces blackheads for clearer skin.",
      ingredients: ["Salicylic Acid", "Green Tea Extract", "Chamomile"],
      benefits: ["Exfoliating", "Pore Clearing", "Anti-Acne"],
      image: "https://images.unsplash.com/photo-1571781926291-c477ebfd024b?w=300&h=200&fit=crop",
      bestseller: true,
      newArrival: false,
      onSale: false
    },

    // Moisturizers
    {
      id: 4,
      name: "Ultra Facial Cream",
      brand: "Kiehl's",
      category: "moisturizer",
      price: 42.00,
      originalPrice: 42.00,
      rating: 4.5,
      reviews: 5673,
      skinTypes: ["normal", "dry", "sensitive"],
      description: "24-hour hydration with glacial glycoprotein and desert plant extracts for all skin types.",
      ingredients: ["Squalane", "Glacial Glycoprotein", "Desert Plant Extracts"],
      benefits: ["24h Hydration", "Non-Greasy", "All Weather Protection"],
      image: "https://images.unsplash.com/photo-1556229174-f6da5d4f7096?w=300&h=200&fit=crop",
      bestseller: true,
      newArrival: false,
      onSale: false
    },
    {
      id: 5,
      name: "Dramatically Different Moisturizing Gel",
      brand: "Clinique",
      category: "moisturizer",
      price: 31.00,
      originalPrice: 38.00,
      rating: 4.4,
      reviews: 4129,
      skinTypes: ["oily", "normal"],
      description: "Oil-free gel moisturizer that strengthens skin's moisture barrier for softer, smoother skin.",
      ingredients: ["Hyaluronic Acid", "Cucumber Extract", "Barley Extract"],
      benefits: ["Oil-Free", "Lightweight", "Barrier Strengthening"],
      image: "https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?w=300&h=200&fit=crop",
      bestseller: false,
      newArrival: false,
      onSale: true
    },
    {
      id: 6,
      name: "Rich Recovery Night Cream",
      brand: "Olay",
      category: "moisturizer",
      price: 28.99,
      originalPrice: 34.99,
      rating: 4.6,
      reviews: 2156,
      skinTypes: ["dry", "mature"],
      description: "Intensive overnight moisturizer with peptides and niacinamide for skin renewal.",
      ingredients: ["Peptides", "Niacinamide", "Vitamin E"],
      benefits: ["Anti-Aging", "Deep Hydration", "Overnight Repair"],
      image: "https://images.unsplash.com/photo-1609840114035-3c981b782dfe?w=300&h=200&fit=crop",
      bestseller: false,
      newArrival: false,
      onSale: true
    },

    // Serums
    {
      id: 7,
      name: "Vitamin C + E Ferulic Serum",
      brand: "SkinCeuticals",
      category: "serum",
      price: 169.00,
      originalPrice: 169.00,
      rating: 4.9,
      reviews: 1847,
      skinTypes: ["normal", "dry", "oily", "acne"],
      description: "Antioxidant serum that prevents environmental damage and brightens skin tone.",
      ingredients: ["L-Ascorbic Acid", "Vitamin E", "Ferulic Acid"],
      benefits: ["Brightening", "Antioxidant Protection", "Anti-Aging"],
      image: "https://images.unsplash.com/photo-1620916297067-f8b9a6cf4d85?w=300&h=200&fit=crop",
      bestseller: true,
      newArrival: false,
      onSale: false
    },
    {
      id: 8,
      name: "The Ordinary Niacinamide 10% + Zinc 1%",
      brand: "The Ordinary",
      category: "serum",
      price: 7.20,
      originalPrice: 7.20,
      rating: 4.3,
      reviews: 8945,
      skinTypes: ["oily", "acne"],
      description: "High-strength vitamin B3 serum that reduces blemishes and regulates sebum production.",
      ingredients: ["Niacinamide", "Zinc PCA"],
      benefits: ["Sebum Control", "Blemish Reduction", "Pore Minimizing"],
      image: "https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?w=300&h=200&fit=crop",
      bestseller: true,
      newArrival: false,
      onSale: false
    },
    {
      id: 9,
      name: "Hyaluronic Acid Intensive Serum",
      brand: "Neutrogena",
      category: "serum",
      price: 19.99,
      originalPrice: 24.99,
      rating: 4.5,
      reviews: 3267,
      skinTypes: ["dry", "normal", "sensitive"],
      description: "Plumps skin with multiple types of hyaluronic acid for instant and long-lasting hydration.",
      ingredients: ["Hyaluronic Acid", "Vitamin B5", "Trehalose"],
      benefits: ["Intense Hydration", "Plumping", "Fine Line Reduction"],
      image: "https://images.unsplash.com/photo-1591218533610-f2de0ecaac7f?w=300&h=200&fit=crop",
      bestseller: false,
      newArrival: true,
      onSale: true
    },

    // Sunscreens
    {
      id: 10,
      name: "Anthelios Ultra Light SPF 60",
      brand: "La Roche-Posay",
      category: "sunscreen",
      price: 36.99,
      originalPrice: 36.99,
      rating: 4.7,
      reviews: 2834,
      skinTypes: ["normal", "oily", "sensitive"],
      description: "Broad-spectrum sunscreen with Cell-Ox Shield technology for superior UV protection.",
      ingredients: ["Avobenzone", "Homosalate", "Octisalate", "Octocrylene"],
      benefits: ["Broad Spectrum Protection", "Water Resistant", "Non-Comedogenic"],
      image: "https://images.unsplash.com/photo-1571781926291-c477ebfd024b?w=300&h=200&fit=crop",
      bestseller: true,
      newArrival: false,
      onSale: false
    },
    {
      id: 11,
      name: "Invisible Zinc SPF 50+",
      brand: "EltaMD",
      category: "sunscreen",
      price: 39.00,
      originalPrice: 39.00,
      rating: 4.8,
      reviews: 1956,
      skinTypes: ["sensitive", "acne", "normal"],
      description: "Clear zinc oxide formula that provides invisible protection without white cast.",
      ingredients: ["Zinc Oxide", "Octinoxate", "Hyaluronic Acid"],
      benefits: ["No White Cast", "Reef Safe", "Sensitive Skin Friendly"],
      image: "https://images.unsplash.com/photo-1556228852-80de6c3ad924?w=300&h=200&fit=crop",
      bestseller: false,
      newArrival: true,
      onSale: false
    },

    // Treatments
    {
      id: 12,
      name: "Advanced Retinol Night Treatment",
      brand: "RoC",
      category: "treatment",
      price: 34.99,
      originalPrice: 42.99,
      rating: 4.4,
      reviews: 1634,
      skinTypes: ["normal", "dry", "mature"],
      description: "Gentle retinol formula that reduces fine lines and improves skin texture overnight.",
      ingredients: ["Retinol", "Glycerin", "Dimethicone"],
      benefits: ["Anti-Aging", "Texture Improvement", "Fine Line Reduction"],
      image: "https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?w=300&h=200&fit=crop",
      bestseller: false,
      newArrival: false,
      onSale: true
    },
    {
      id: 13,
      name: "AHA/BHA Exfoliating Toner",
      brand: "Paula's Choice",
      category: "treatment",
      price: 29.00,
      originalPrice: 29.00,
      rating: 4.6,
      reviews: 4521,
      skinTypes: ["oily", "acne", "normal"],
      description: "Dual-action exfoliant that unclogs pores and smooths skin texture for a clearer complexion.",
      ingredients: ["Salicylic Acid", "Glycolic Acid", "Green Tea"],
      benefits: ["Exfoliating", "Pore Refining", "Texture Smoothing"],
      image: "https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=300&h=200&fit=crop",
      bestseller: true,
      newArrival: false,
      onSale: false
    },

    // Masks
    {
      id: 14,
      name: "Hydrating Sleep Mask",
      brand: "Laneige",
      category: "mask",
      price: 34.00,
      originalPrice: 34.00,
      rating: 4.7,
      reviews: 2789,
      skinTypes: ["dry", "normal", "sensitive"],
      description: "Overnight mask with Sleepscience technology that deeply hydrates and repairs skin while you sleep.",
      ingredients: ["Hunza Apricot Extract", "Evening Primrose Root Extract", "Sleepscience Technology"],
      benefits: ["Overnight Hydration", "Skin Repair", "Plumping"],
      image: "https://images.unsplash.com/photo-1556228720-195a672e8a03?w=300&h=200&fit=crop",
      bestseller: true,
      newArrival: false,
      onSale: false
    },
    {
      id: 15,
      name: "Clay Purifying Mask",
      brand: "Origins",
      category: "mask",
      price: 38.00,
      originalPrice: 45.00,
      rating: 4.5,
      reviews: 1423,
      skinTypes: ["oily", "acne"],
      description: "White China clay mask that draws out impurities and excess oil for clearer, refined pores.",
      ingredients: ["White China Clay", "Lecithin", "Cucumber Extract"],
      benefits: ["Deep Cleansing", "Oil Control", "Pore Refining"],
      image: "https://images.unsplash.com/photo-1570554886111-e80fcac6c36b?w=300&h=200&fit=crop",
      bestseller: false,
      newArrival: false,
      onSale: true
    },

    // Eye Care
    {
      id: 16,
      name: "Advanced Eye Renewal Cream",
      brand: "Estée Lauder",
      category: "eye-care",
      price: 89.00,
      originalPrice: 89.00,
      rating: 4.6,
      reviews: 987,
      skinTypes: ["mature", "dry", "normal"],
      description: "Targeted eye cream that reduces dark circles, puffiness, and fine lines around the delicate eye area.",
      ingredients: ["Caffeine", "Peptides", "Hyaluronic Acid"],
      benefits: ["Dark Circle Reduction", "Anti-Puffiness", "Fine Line Smoothing"],
      image: "https://images.unsplash.com/photo-1609840114035-3c981b782dfe?w=300&h=200&fit=crop",
      bestseller: false,
      newArrival: true,
      onSale: false
    },

    // Toners
    {
      id: 17,
      name: "Alcohol-Free Rose Toner",
      brand: "Thayers",
      category: "toner",
      price: 12.95,
      originalPrice: 15.95,
      rating: 4.4,
      reviews: 5634,
      skinTypes: ["sensitive", "dry", "normal"],
      description: "Witch hazel toner with rose petals that balances pH and prepares skin for moisturizer.",
      ingredients: ["Witch Hazel", "Rose Petal Water", "Aloe Vera"],
      benefits: ["pH Balancing", "Soothing", "Alcohol-Free"],
      image: "https://images.unsplash.com/photo-1591218533610-f2de0ecaac7f?w=300&h=200&fit=crop",
      bestseller: true,
      newArrival: false,
      onSale: true
    },

    // Exfoliants
    {
      id: 18,
      name: "Gentle Enzyme Exfoliant",
      brand: "Dermalogica",
      category: "exfoliant",
      price: 58.00,
      originalPrice: 58.00,
      rating: 4.7,
      reviews: 1245,
      skinTypes: ["sensitive", "dry", "normal"],
      description: "Rice-based powder that activates with water to gently remove dead skin cells without irritation.",
      ingredients: ["Rice Enzymes", "Papain", "Salicylic Acid"],
      benefits: ["Gentle Exfoliation", "Brightening", "Non-Irritating"],
      image: "https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?w=300&h=200&fit=crop",
      bestseller: false,
      newArrival: true,
      onSale: false
    }
  ];

  // Extract unique values for filters
  const categories = [...new Set(products.map(p => p.category))];
  const brands = [...new Set(products.map(p => p.brand))];
  const skinTypes = ['normal', 'oily', 'dry', 'acne', 'sensitive', 'mature'];

  // Filter and search logic
  const filteredProducts = useMemo(() => {
    return products.filter(product => {
      const matchesSearch = product.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                          product.brand.toLowerCase().includes(searchTerm.toLowerCase()) ||
                          product.description.toLowerCase().includes(searchTerm.toLowerCase()) ||
                          product.ingredients.some(ing => ing.toLowerCase().includes(searchTerm.toLowerCase()));
      
      const matchesCategory = selectedCategory === 'all' || product.category === selectedCategory;
      const matchesSkinType = selectedSkinType === 'all' || product.skinTypes.includes(selectedSkinType);
      const matchesBrand = selectedBrand === 'all' || product.brand === selectedBrand;
      const matchesPrice = product.price >= priceRange[0] && product.price <= priceRange[1];

      return matchesSearch && matchesCategory && matchesSkinType && matchesBrand && matchesPrice;
    }).sort((a, b) => {
      switch (sortBy) {
        case 'price-low':
          return a.price - b.price;
        case 'price-high':
          return b.price - a.price;
        case 'rating':
          return b.rating - a.rating;
        case 'popularity':
          return b.reviews - a.reviews;
        case 'newest':
          return b.newArrival - a.newArrival;
        default:
          return 0;
      }
    });
  }, [searchTerm, selectedCategory, selectedSkinType, selectedBrand, sortBy, priceRange, products]);

  const toggleWishlist = (productId) => {
    setWishlist(prev => 
      prev.includes(productId) 
        ? prev.filter(id => id !== productId)
        : [...prev, productId]
    );
  };

  const addToCart = (product) => {
    setCart(prev => {
      const existing = prev.find(item => item.id === product.id);
      if (existing) {
        return prev.map(item =>
          item.id === product.id 
            ? { ...item, quantity: item.quantity + 1 }
            : item
        );
      }
      return [...prev, { ...product, quantity: 1 }];
    });
  };

  const formatPrice = (price) => `$${price.toFixed(2)}`;

  const renderStars = (rating) => {
    const stars = [];
    const fullStars = Math.floor(rating);
    const hasHalfSar = rating % 1 !== 0;
    
    for (let i = 0; i < 5; i++) {
      if (i < fullStars) {
        stars.push('★');
      } else if (i === fullStars && hasHalfSar) {
        stars.push('☆');
      } else {
        stars.push('☆');
      }
    }
    return stars.join('');
  };

  const getSkinTypeColor = (skinType) => {
    const colors = {
      normal: '#28a745',
      oily: '#ffc107',
      dry: '#17a2b8',
      acne: '#dc3545',
      sensitive: '#6f42c1',
      mature: '#fd7e14'
    };
    return colors[skinType] || '#6c757d';
  };

  return (
    <div style={{
      minHeight: '100vh',
      background: backgroundColor,
      padding: '2rem 1rem',
      fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif'
    }}>
      <div style={{ maxWidth: '1400px', margin: '0 auto' }}>
        
        {/* Header */}
        <div style={{ 
          textAlign: 'center', 
          marginBottom: '3rem',
          background: 'rgba(255, 255, 255, 0.1)',
          backdropFilter: 'blur(10px)',
          borderRadius: '20px',
          padding: '2rem'
        }}>
          <h1 style={{
            fontSize: '3rem',
            fontWeight: 'bold',
            marginBottom: '1rem',
            background: 'linear-gradient(45deg, white, rgba(255,255,255,0.8))',
            WebkitBackgroundClip: 'text',
            WebkitTextFillColor: 'transparent',
            backgroundClip: 'text'
          }}>
            Skincare Products Catalog
          </h1>
          <p style={{
            fontSize: '1.2rem',
            color: 'rgba(255, 255, 255, 0.9)',
            maxWidth: '600px',
            margin: '0 auto'
          }}>
            Discover the perfect skincare products for your unique skin type and concerns
          </p>
        </div>

        {/* Search and Filters */}
        <div style={{
          background: 'rgba(255, 255, 255, 0.95)',
          borderRadius: '20px',
          padding: '2rem',
          marginBottom: '2rem',
          boxShadow: '0 10px 40px rgba(0, 0, 0, 0.1)'
        }}>
          
          {/* Search Bar */}
          <div style={{ marginBottom: '2rem' }}>
            <div style={{ position: 'relative', maxWidth: '500px', margin: '0 auto' }}>
              <input
                type="text"
                placeholder="Search products, brands, or ingredients..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                style={{
                  width: '100%',
                  padding: '1rem 3rem 1rem 1rem',
                  fontSize: '1.1rem',
                  border: `2px solid ${primaryColor}`,
                  borderRadius: '50px',
                  outline: 'none',
                  transition: 'border-color 0.3s, box-shadow 0.3s'
                }}
                onFocus={(e) => e.target.style.boxShadow = `0 0 0 3px rgba(102, 126, 234, 0.1)`}
                onBlur={(e) => e.target.style.boxShadow = 'none'}
              />
              <div style={{
                position: 'absolute',
                right: '1rem',
                top: '50%',
                transform: 'translateY(-50%)',
                color: primaryColor,
                fontSize: '1.2rem'
              }}>
                🔍
              </div>
            </div>
          </div>

          {/* Filters */}
          <div style={{ 
            display: 'grid', 
            gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))', 
            gap: '1rem',
            marginBottom: '1rem'
          }}>
            
            <select
              value={selectedCategory}
              onChange={(e) => setSelectedCategory(e.target.value)}
              style={{
                padding: '0.75rem',
                fontSize: '1rem',
                border: `2px solid ${primaryColor}`,
                borderRadius: '10px',
                backgroundColor: 'white',
                cursor: 'pointer'
              }}
            >
              <option value="all">All Categories</option>
              {categories.map(category => (
                <option key={category} value={category}>
                  {category.charAt(0).toUpperCase() + category.slice(1).replace('-', ' ')}
                </option>
              ))}
            </select>

            <select
              value={selectedSkinType}
              onChange={(e) => setSelectedSkinType(e.target.value)}
              style={{
                padding: '0.75rem',
                fontSize: '1rem',
                border: `2px solid ${primaryColor}`,
                borderRadius: '10px',
                backgroundColor: 'white',
                cursor: 'pointer'
              }}
            >
              <option value="all">All Skin Types</option>
              {skinTypes.map(skinType => (
                <option key={skinType} value={skinType}>
                  {skinType.charAt(0).toUpperCase() + skinType.slice(1)}
                </option>
              ))}
            </select>

            <select
              value={selectedBrand}
              onChange={(e) => setSelectedBrand(e.target.value)}
              style={{
                padding: '0.75rem',
                fontSize: '1rem',
                border: `2px solid ${primaryColor}`,
                borderRadius: '10px',
                backgroundColor: 'white',
                cursor: 'pointer'
              }}
            >
              <option value="all">All Brands</option>
              {brands.map(brand => (
                <option key={brand} value={brand}>{brand}</option>
              ))}
            </select>

            <select
              value={sortBy}
              onChange={(e) => setSortBy(e.target.value)}
              style={{
                padding: '0.75rem',
                fontSize: '1rem',
                border: `2px solid ${primaryColor}`,
                borderRadius: '10px',
                backgroundColor: 'white',
                cursor: 'pointer'
              }}
            >
              <option value="popularity">Most Popular</option>
              <option value="rating">Highest Rated</option>
              <option value="price-low">Price: Low to High</option>
              <option value="price-high">Price: High to Low</option>
              <option value="newest">Newest</option>
            </select>
          </div>

          {/* User's Skin Type Highlight */}
          {userSkinType && (
            <div style={{
              background: `linear-gradient(45deg, ${primaryColor}, ${secondaryColor})`,
              color: 'white',
              padding: '1rem',
              borderRadius: '10px',
              textAlign: 'center',
              marginTop: '1rem'
            }}>
              <strong>Recommended for your {userSkinType} skin type</strong>
              <button
                onClick={() => setSelectedSkinType(userSkinType)}
                style={{
                  marginLeft: '1rem',
                  padding: '0.5rem 1rem',
                  background: 'rgba(255, 255, 255, 0.2)',
                  color: 'white',
                  border: '1px solid rgba(255, 255, 255, 0.3)',
                  borderRadius: '20px',
                  cursor: 'pointer'
                }}
              >
                Show My Products
              </button>
            </div>
          )}
        </div>

        {/* Results Count */}
        <div style={{
          textAlign: 'center',
          marginBottom: '2rem',
          color: 'white',
          fontSize: '1.1rem'
        }}>
          Showing {filteredProducts.length} of {products.length} products
        </div>

        {/* Products Grid */}
        <div style={{
          display: 'grid',
          gridTemplateColumns: 'repeat(auto-fill, minmax(320px, 1fr))',
          gap: '2rem',
          marginBottom: '3rem'
        }}>
          {filteredProducts.map((product, index) => (
            <div
              key={product.id}
              style={{
                background: 'rgba(255, 255, 255, 0.95)',
                borderRadius: '20px',
                padding: '1.5rem',
                boxShadow: '0 10px 40px rgba(0, 0, 0, 0.1)',
                transition: 'transform 0.3s, box-shadow 0.3s',
                position: 'relative',
                cursor: 'pointer',
                animation: `fadeInUp 0.6s ease-out ${index * 0.1}s both`
              }}
              onMouseEnter={(e) => {
                e.currentTarget.style.transform = 'translateY(-8px)';
                e.currentTarget.style.boxShadow = '0 20px 60px rgba(0, 0, 0, 0.15)';
              }}
              onMouseLeave={(e) => {
                e.currentTarget.style.transform = 'translateY(0)';
                e.currentTarget.style.boxShadow = '0 10px 40px rgba(0, 0, 0, 0.1)';
              }}
              onClick={() => onProductSelect && onProductSelect(product)}
            >
              
              {/* Badges */}
              <div style={{ position: 'absolute', top: '1rem', right: '1rem', display: 'flex', gap: '0.5rem' }}>
                {product.bestseller && (
                  <span style={{
                    background: accentColor,
                    color: 'white',
                    padding: '0.25rem 0.5rem',
                    borderRadius: '12px',
                    fontSize: '0.7rem',
                    fontWeight: 'bold'
                  }}>
                    BESTSELLER
                  </span>
                )}
                {product.newArrival && (
                  <span style={{
                    background: '#ff6b35',
                    color: 'white',
                    padding: '0.25rem 0.5rem',
                    borderRadius: '12px',
                    fontSize: '0.7rem',
                    fontWeight: 'bold'
                  }}>
                    NEW
                  </span>
                )}
                {product.onSale && (
                  <span style={{
                    background: '#e74c3c',
                    color: 'white',
                    padding: '0.25rem 0.5rem',
                    borderRadius: '12px',
                    fontSize: '0.7rem',
                    fontWeight: 'bold'
                  }}>
                    SALE
                  </span>
                )}
              </div>

              {/* Wishlist Button */}
              {showWishlist && (
                <button
                  onClick={(e) => {
                    e.stopPropagation();
                    toggleWishlist(product.id);
                  }}
                  style={{
                    position: 'absolute',
                    top: '1rem',
                    left: '1rem',
                    background: 'none',
                    border: 'none',
                    fontSize: '1.5rem',
                    cursor: 'pointer',
                    color: wishlist.includes(product.id) ? '#e74c3c' : '#ccc',
                    transition: 'color 0.3s'
                  }}
                >
                  {wishlist.includes(product.id) ? '❤️' : '🤍'}
                </button>
              )}

              {/* Product Image */}
              <div style={{
                width: '100%',
                height: '200px',
                borderRadius: '15px',
                overflow: 'hidden',
                marginBottom: '1rem'
              }}>
                <img
                  src={product.image}
                  alt={product.name}
                  style={{
                    width: '100%',
                    height: '100%',
                    objectFit: 'cover'
                  }}
                />
              </div>

              {/* Product Info */}
              <div>
                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: '0.5rem' }}>
                  <h3 style={{
                    fontSize: '1.2rem',
                    fontWeight: 'bold',
                    color: '#333',
                    margin: 0,
                    lineHeight: '1.3'
                  }}>
                    {product.name}
                  </h3>
                </div>

                <p style={{
                  color: primaryColor,
                  fontSize: '0.9rem',
                  fontWeight: '600',
                  marginBottom: '0.5rem'
                }}>
                  {product.brand}
                </p>

                {/* Rating */}
                <div style={{
                  display: 'flex',
                  alignItems: 'center',
                  gap: '0.5rem',
                  marginBottom: '0.75rem'
                }}>
                  <span style={{ color: '#ffc107', fontSize: '0.9rem' }}>
                    {renderStars(product.rating)}
                  </span>
                  <span style={{ fontSize: '0.8rem', color: '#666' }}>
                    {product.rating} ({product.reviews} reviews)
                  </span>
                </div>

                {/* Skin Types */}
                <div style={{ marginBottom: '0.75rem' }}>
                  {product.skinTypes.map((skinType, idx) => (
                    <span
                      key={idx}
                      style={{
                        display: 'inline-block',
                        background: getSkinTypeColor(skinType),
                        color: 'white',
                        padding: '0.2rem 0.5rem',
                        borderRadius: '10px',
                        fontSize: '0.7rem',
                        marginRight: '0.3rem',
                        marginBottom: '0.3rem',
                        textTransform: 'capitalize',
                        fontWeight: '500'
                      }}
                    >
                      {skinType}
                    </span>
                  ))}
                </div>

                {/* Description */}
                <p style={{
                  fontSize: '0.85rem',
                  color: '#666',
                  lineHeight: '1.5',
                  marginBottom: '1rem',
                  display: '-webkit-box',
                  WebkitLineClamp: 3,
                  WebkitBoxOrient: 'vertical',
                  overflow: 'hidden'
                }}>
                  {product.description}
                </p>

                {/* Key Benefits */}
                <div style={{ marginBottom: '1rem' }}>
                  <h5 style={{ fontSize: '0.8rem', fontWeight: '600', color: '#333', marginBottom: '0.5rem' }}>
                    Key Benefits:
                  </h5>
                  <div style={{ display: 'flex', flexWrap: 'wrap', gap: '0.25rem' }}>
                    {product.benefits.slice(0, 3).map((benefit, idx) => (
                      <span
                        key={idx}
                        style={{
                          background: `rgba(${primaryColor === '#667eea' ? '102, 126, 234' : '118, 75, 162'}, 0.1)`,
                          color: primaryColor,
                          padding: '0.2rem 0.4rem',
                          borderRadius: '8px',
                          fontSize: '0.7rem',
                          fontWeight: '500'
                        }}
                      >
                        {benefit}
                      </span>
                    ))}
                  </div>
                </div>

                {/* Price and Actions */}
                <div style={{
                  display: 'flex',
                  justifyContent: 'space-between',
                  alignItems: 'center',
                  marginTop: 'auto',
                  paddingTop: '1rem',
                  borderTop: '1px solid #eee'
                }}>
                  <div>
                    <span style={{
                      fontSize: '1.3rem',
                      fontWeight: 'bold',
                      color: primaryColor
                    }}>
                      {formatPrice(product.price)}
                    </span>
                    {product.onSale && product.originalPrice > product.price && (
                      <span style={{
                        fontSize: '0.9rem',
                        color: '#999',
                        textDecoration: 'line-through',
                        marginLeft: '0.5rem'
                      }}>
                        {formatPrice(product.originalPrice)}
                      </span>
                    )}
                  </div>

                  {showAddToCart && (
                    <button
                      onClick={(e) => {
                        e.stopPropagation();
                        addToCart(product);
                      }}
                      style={{
                        background: `linear-gradient(45deg, ${primaryColor}, ${secondaryColor})`,
                        color: 'white',
                        border: 'none',
                        borderRadius: '10px',
                        padding: '0.6rem 1.2rem',
                        fontSize: '0.85rem',
                        fontWeight: '600',
                        cursor: 'pointer',
                        transition: 'transform 0.2s'
                      }}
                      onMouseEnter={(e) => e.target.style.transform = 'scale(1.05)'}
                      onMouseLeave={(e) => e.target.style.transform = 'scale(1)'}
                    >
                      Add to Cart
                    </button>
                  )}
                </div>
              </div>
            </div>
          ))}
        </div>

        {/* No Results */}
        {filteredProducts.length === 0 && (
          <div style={{
            background: 'rgba(255, 255, 255, 0.95)',
            borderRadius: '20px',
            padding: '4rem 2rem',
            textAlign: 'center',
            marginTop: '2rem'
          }}>
            <div style={{ fontSize: '4rem', marginBottom: '1rem' }}>🔍</div>
            <h3 style={{ marginBottom: '1rem', color: '#333' }}>No products found</h3>
            <p style={{ color: '#666', marginBottom: '2rem' }}>
              Try adjusting your filters or search terms to find what you're looking for.
            </p>
            <button
              onClick={() => {
                setSearchTerm('');
                setSelectedCategory('all');
                setSelectedSkinType('all');
                setSelectedBrand('all');
                setSortBy('popularity');
                setPriceRange([0, 200]);
              }}
              style={{
                background: `linear-gradient(45deg, ${primaryColor}, ${secondaryColor})`,
                color: 'white',
                border: 'none',
                borderRadius: '10px',
                padding: '0.75rem 1.5rem',
                fontSize: '1rem',
                fontWeight: '600',
                cursor: 'pointer'
              }}
            >
              Clear All Filters
            </button>
          </div>
        )}

        {/* Cart Summary */}
        {showAddToCart && cart.length > 0 && (
          <div style={{
            position: 'fixed',
            bottom: '2rem',
            right: '2rem',
            background: `linear-gradient(45deg, ${primaryColor}, ${secondaryColor})`,
            color: 'white',
            padding: '1rem 1.5rem',
            borderRadius: '50px',
            boxShadow: '0 10px 30px rgba(0, 0, 0, 0.2)',
            cursor: 'pointer',
            transition: 'transform 0.3s'
          }}
          onMouseEnter={(e) => e.currentTarget.style.transform = 'scale(1.05)'}
          onMouseLeave={(e) => e.currentTarget.style.transform = 'scale(1)'}
          onClick={() => {
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            alert(`Cart: ${cart.length} items, Total: ${formatPrice(total)}`);
          }}
          >
            🛒 {cart.reduce((sum, item) => sum + item.quantity, 0)} items
          </div>
        )}
      </div>

      <style jsx>{`
        @keyframes fadeInUp {
          from {
            opacity: 0;
            transform: translateY(30px);
          }
          to {
            opacity: 1;
            transform: translateY(0);
          }
        }
      `}</style>
    </div>
  );
};

export default SkincareProductsCatalog;