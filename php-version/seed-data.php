<?php
/** NexusTech — seed data used by setup.php (24 products, 6 categories). */

function seed_img(string $id, int $w = 900): string
{
    return "https://images.unsplash.com/$id?auto=format&fit=crop&w=$w&q=80";
}

function seed_gallery(string $main, array $extra = []): array
{
    return array_map(fn ($id) => seed_img($id), array_merge([$main], $extra));
}

const SEED_CATEGORIES = [
    ['slug' => 'phones',      'label' => 'Phones',      'icon' => '📱', 'tagline' => 'Flagship power in your pocket'],
    ['slug' => 'laptops',     'label' => 'Laptops',     'icon' => '💻', 'tagline' => 'Desktop-class performance'],
    ['slug' => 'audio',       'label' => 'Audio',       'icon' => '🎧', 'tagline' => 'Studio-grade sound'],
    ['slug' => 'wearables',   'label' => 'Wearables',   'icon' => '⌚', 'tagline' => 'Health & fitness on your wrist'],
    ['slug' => 'cameras',     'label' => 'Cameras',     'icon' => '📷', 'tagline' => 'Capture every moment'],
    ['slug' => 'accessories', 'label' => 'Accessories', 'icon' => '🎮', 'tagline' => 'Complete your setup'],
];

const SEED_PRODUCTS = [
    ['slug' => 'nova-x9-pro', 'name' => 'Nova X9 Pro', 'brand' => 'Nova', 'category' => 'phones',
     'price' => 1099, 'old_price' => 1249, 'rating' => 4.9, 'reviews' => 2314, 'stock' => 34, 'badge' => 'Flagship',
     'colors' => ['#1c1c1e', '#8e8e93', '#0a84ff'],
     'short' => 'Titanium body, 6.8" LTPO AMOLED and a 200MP AI camera system.',
     'description' => 'The Nova X9 Pro is our most advanced smartphone ever. A grade-5 titanium frame wraps a 6.8-inch LTPO AMOLED display with 1–120Hz adaptive refresh and 2600-nit peak brightness. The 200MP main sensor with sensor-shift stabilization captures stunning detail in any light, while the 5400mAh silicon-carbon battery delivers all-day endurance and 80W fast charging.',
     'specs' => ['Display' => '6.8" LTPO AMOLED, 120Hz, 2600 nits', 'Chip' => 'Fusion A18 Pro, 3nm', 'Camera' => '200MP + 50MP UW + 12MP 5x Tele', 'Battery' => '5400mAh, 80W wired / 50W wireless', 'Storage' => '256GB / 512GB / 1TB', 'Water resistance' => 'IP68'],
     'images' => 'photo-1592750475338-74b7b21085ab photo-1511707171634-5f897ff02aa9 photo-1610945415295-d9bbf067e59c'],

    ['slug' => 'nova-x9', 'name' => 'Nova X9', 'brand' => 'Nova', 'category' => 'phones',
     'price' => 799, 'old_price' => null, 'rating' => 4.7, 'reviews' => 1548, 'stock' => 58, 'badge' => null,
     'colors' => ['#2c2c2e', '#5e5ce6', '#f2f2f7'],
     'short' => 'All the flagship smarts, perfectly balanced size and price.',
     'description' => 'Nova X9 distills the flagship experience into a compact 6.1-inch body. The Fusion A18 chip, dual 48MP camera system and ceramic-shield front glass make it the smartest upgrade in the lineup — with the same AI photography pipeline as the Pro.',
     'specs' => ['Display' => '6.1" OLED, 120Hz, 2000 nits', 'Chip' => 'Fusion A18, 3nm', 'Camera' => '48MP + 12MP UW', 'Battery' => '4400mAh, 45W wired', 'Storage' => '128GB / 256GB / 512GB', 'Water resistance' => 'IP68'],
     'images' => 'photo-1511707171634-5f897ff02aa9 photo-1592750475338-74b7b21085ab photo-1610945415295-d9bbf067e59c'],

    ['slug' => 'orbit-s24-ultra', 'name' => 'Orbit S24 Ultra', 'brand' => 'Orbit', 'category' => 'phones',
     'price' => 1199, 'old_price' => 1299, 'rating' => 4.8, 'reviews' => 1876, 'stock' => 21, 'badge' => 'New',
     'colors' => ['#3a3a3c', '#d1c4e9', '#ffd60a'],
     'short' => 'Built-in S Pen, quad telephoto zoom and a 100x space zoom.',
     'description' => 'The Orbit S24 Ultra pairs a 6.9" QHD+ Dynamic AMOLED with an integrated S Pen and a versatile quad camera anchored by a 200MP main sensor. Orbit Intelligence brings on-device AI translation, photo remastering and note summarization.',
     'specs' => ['Display' => '6.9" QHD+ AMOLED, 120Hz', 'Chip' => 'Orbit Exynos 2600', 'Camera' => '200MP + 12MP UW + 50MP 5x + 10MP 10x', 'Battery' => '5000mAh, 65W wired', 'Storage' => '256GB / 512GB / 1TB', 'Water resistance' => 'IP68'],
     'images' => 'photo-1610945415295-d9bbf067e59c photo-1592750475338-74b7b21085ab photo-1511707171634-5f897ff02aa9'],

    ['slug' => 'pixel-lite-5g', 'name' => 'Pixel Lite 5G', 'brand' => 'Zenith', 'category' => 'phones',
     'price' => 449, 'old_price' => 529, 'rating' => 4.5, 'reviews' => 932, 'stock' => 76, 'badge' => 'Best value',
     'colors' => ['#0a84ff', '#30d158', '#1c1c1e'],
     'short' => 'Mid-range champion with a 120Hz screen and clean software.',
     'description' => 'Pixel Lite 5G proves you do not need a flagship budget for a flagship feel. A 6.5" 120Hz pOLED panel, 64MP OIS camera and two days of battery life in a 178g body.',
     'specs' => ['Display' => '6.5" pOLED, 120Hz', 'Chip' => 'Zenith Core 7 Gen 3', 'Camera' => '64MP OIS + 8MP UW', 'Battery' => '5000mAh, 33W wired', 'Storage' => '128GB / 256GB', 'Water resistance' => 'IP54'],
     'images' => 'photo-1580910051074-3eb694886505 photo-1511707171634-5f897ff02aa9 photo-1592750475338-74b7b21085ab'],

    ['slug' => 'aerobook-pro-16', 'name' => 'AeroBook Pro 16', 'brand' => 'Aero', 'category' => 'laptops',
     'price' => 2399, 'old_price' => 2599, 'rating' => 4.9, 'reviews' => 1120, 'stock' => 12, 'badge' => 'Flagship',
     'colors' => ['#1d1d1f', '#8e8e93'],
     'short' => '16" mini-LED workstation with 22-hour battery life.',
     'description' => 'AeroBook Pro 16 is a mobile workstation without compromise. The M4-class 12-core CPU and 18-core GPU render 8K timelines, the 16" mini-LED display hits 1600 nits peak HDR, and a 100Wh battery keeps it running for up to 22 hours.',
     'specs' => ['Display' => '16.2" mini-LED, 120Hz, 1600 nits HDR', 'Chip' => 'Aero M4 Pro, 12-core CPU / 18-core GPU', 'Memory' => '24GB unified (up to 128GB)', 'Storage' => '512GB SSD (up to 8TB)', 'Battery' => '100Wh, up to 22 hours', 'Weight' => '2.14 kg'],
     'images' => 'photo-1517336714731-489689fd1ca8 photo-1496181133206-80ce9b88a853 photo-1525547719571-a2d4ac8945e2'],

    ['slug' => 'aerobook-air-13', 'name' => 'AeroBook Air 13', 'brand' => 'Aero', 'category' => 'laptops',
     'price' => 1099, 'old_price' => null, 'rating' => 4.8, 'reviews' => 2043, 'stock' => 40, 'badge' => 'Best seller',
     'colors' => ['#e3e4e5', '#1d1d1f', '#0a84ff'],
     'short' => 'Impossibly thin, fanless, and fast for everything you do.',
     'description' => 'Just 11.3mm thin and 1.24kg light, AeroBook Air 13 is the everyday laptop perfected. The fanless M4 chip stays silent under load, and the 13.6" Liquid Retina display makes everything look stunning.',
     'specs' => ['Display' => '13.6" Liquid Retina, 500 nits', 'Chip' => 'Aero M4, 8-core CPU / 10-core GPU', 'Memory' => '16GB unified', 'Storage' => '256GB / 512GB SSD', 'Battery' => '53.8Wh, up to 18 hours', 'Weight' => '1.24 kg'],
     'images' => 'photo-1496181133206-80ce9b88a853 photo-1517336714731-489689fd1ca8 photo-1525547719571-a2d4ac8945e2'],

    ['slug' => 'vortex-blade-15', 'name' => 'Vortex Blade 15', 'brand' => 'Vortex', 'category' => 'laptops',
     'price' => 1799, 'old_price' => 1999, 'rating' => 4.6, 'reviews' => 764, 'stock' => 18, 'badge' => null,
     'colors' => ['#161616', '#ff453a'],
     'short' => 'RTX power, 240Hz QHD panel, vapor-chamber cooling.',
     'description' => 'Built for competitive play, the Vortex Blade 15 combines a 14th-gen i7 with an RTX 4070 GPU in a 19.9mm chassis. The 240Hz QHD panel and per-key RGB keyboard make it as beautiful as it is brutal.',
     'specs' => ['Display' => '15.6" QHD IPS, 240Hz', 'Chip' => 'Intel i7-14650HX', 'Graphics' => 'RTX 4070 8GB', 'Memory' => '16GB DDR5 (up to 64GB)', 'Storage' => '1TB NVMe SSD', 'Weight' => '2.1 kg'],
     'images' => 'photo-1525547719571-a2d4ac8945e2 photo-1517336714731-489689fd1ca8 photo-1496181133206-80ce9b88a853'],

    ['slug' => 'slate-flex-14', 'name' => 'Slate Flex 14', 'brand' => 'Zenith', 'category' => 'laptops',
     'price' => 849, 'old_price' => 949, 'rating' => 4.4, 'reviews' => 521, 'stock' => 33, 'badge' => 'Convertible',
     'colors' => ['#2c2c2e', '#64d2ff'],
     'short' => '360° convertible with pen support and all-day battery.',
     'description' => 'Slate Flex 14 flips from laptop to tablet to tent mode in one motion. The 14" 2.2K touchscreen supports 4096 levels of pen pressure, and the aluminum chassis still manages 14 hours of battery.',
     'specs' => ['Display' => '14" 2.2K touch, 90Hz', 'Chip' => 'Zenith Core 7', 'Memory' => '16GB LPDDR5', 'Storage' => '512GB SSD', 'Battery' => '65Wh, up to 14 hours', 'Weight' => '1.45 kg'],
     'images' => 'photo-1544244015-0df4b3ffc6b0 photo-1496181133206-80ce9b88a853 photo-1517336714731-489689fd1ca8'],

    ['slug' => 'sonic-max-anc', 'name' => 'Sonic Max ANC', 'brand' => 'Sonic', 'category' => 'audio',
     'price' => 399, 'old_price' => 449, 'rating' => 4.8, 'reviews' => 3210, 'stock' => 64, 'badge' => 'Best seller',
     'colors' => ['#1c1c1e', '#d6d3d1'],
     'short' => 'Reference-grade over-ears with adaptive noise cancellation.',
     'description' => 'Sonic Max ANC delivers Hi-Res wireless audio with LDAC, adaptive hybrid noise cancellation and 40-hour battery life. Memory-foam ear cushions and a machined aluminum headband keep long sessions comfortable.',
     'specs' => ['Type' => 'Over-ear, closed back', 'Drivers' => '40mm dynamic, Hi-Res certified', 'ANC' => 'Adaptive hybrid, 8 mics', 'Battery' => '40h (ANC on), 10 min = 5h', 'Codecs' => 'LDAC, aptX HD, AAC', 'Weight' => '250 g'],
     'images' => 'photo-1505740420928-5e560c06d30e photo-1583394838336-acd977736f90 photo-1484704849700-f032a568e944'],

    ['slug' => 'sonic-buds-pro', 'name' => 'Sonic Buds Pro', 'brand' => 'Sonic', 'category' => 'audio',
     'price' => 199, 'old_price' => 249, 'rating' => 4.7, 'reviews' => 4122, 'stock' => 120, 'badge' => 'New',
     'colors' => ['#f2f2f7', '#1c1c1e', '#0a84ff'],
     'short' => 'Tiny earbuds, massive sound, with spatial audio.',
     'description' => 'Sonic Buds Pro pack 11mm drivers, personalized spatial audio and active noise cancellation into a pocket-sized case. IPX4 sweat resistance and 32 hours of total battery make them the perfect everyday pair.',
     'specs' => ['Type' => 'In-ear, true wireless', 'Drivers' => '11mm dynamic', 'ANC' => 'Active, 3 mics per bud', 'Battery' => '8h buds / 32h with case', 'Codecs' => 'AAC, aptX Adaptive', 'Water resistance' => 'IPX4'],
     'images' => 'photo-1600294037681-c80b4cb5b434 photo-1590658268037-6bf12165a8df photo-1572569511254-d8f925fe2cbb'],

    ['slug' => 'pulse-studio-monitor', 'name' => 'Pulse Studio Monitor', 'brand' => 'Pulse', 'category' => 'audio',
     'price' => 249, 'old_price' => null, 'rating' => 4.6, 'reviews' => 689, 'stock' => 45, 'badge' => null,
     'colors' => ['#1c1c1e'],
     'short' => 'Flat-response studio headphones for mixing and mastering.',
     'description' => 'The Pulse Studio Monitor is tuned flat for accurate mixing. Detachable braided cable, replaceable velour pads and a 3.5mm + 6.3mm dual plug make it a studio staple.',
     'specs' => ['Type' => 'Over-ear, open back', 'Drivers' => '45mm neodymium', 'Response' => '5Hz – 40kHz', 'Impedance' => '80 ohms', 'Cable' => 'Detachable 3m braided', 'Weight' => '294 g'],
     'images' => 'photo-1583394838336-acd977736f90 photo-1505740420928-5e560c06d30e photo-1484704849700-f032a568e944'],

    ['slug' => 'boom-360-speaker', 'name' => 'Boom 360 Speaker', 'brand' => 'Pulse', 'category' => 'audio',
     'price' => 129, 'old_price' => 159, 'rating' => 4.5, 'reviews' => 1502, 'stock' => 88, 'badge' => 'Deal',
     'colors' => ['#0a84ff', '#1c1c1e', '#ff9f0a'],
     'short' => 'Room-filling 360° sound, IP67 waterproof, 24h playtime.',
     'description' => 'Boom 360 radiates sound in every direction with dual passive radiators for deep bass. Fully waterproof and dustproof, it floats — and pairs two together for true stereo.',
     'specs' => ['Output' => '30W RMS', 'Battery' => '24 hours', 'Water resistance' => 'IP67, floats', 'Bluetooth' => '5.3, multipoint', 'Extras' => 'Stereo pairing, USB-C', 'Weight' => '690 g'],
     'images' => 'photo-1608043152269-423dbba4e7e1 photo-1505740420928-5e560c06d30e photo-1589003077984-894e133dabab'],

    ['slug' => 'chrono-watch-ultra', 'name' => 'Chrono Watch Ultra', 'brand' => 'Chrono', 'category' => 'wearables',
     'price' => 799, 'old_price' => 899, 'rating' => 4.9, 'reviews' => 987, 'stock' => 27, 'badge' => 'Flagship',
     'colors' => ['#1c1c1e', '#ff9f0a'],
     'short' => 'Titanium adventure watch with dual-band GPS and 36h battery.',
     'description' => 'Chrono Watch Ultra is built for extremes: a 49mm titanium case, sapphire crystal, 100m water resistance and dual-band precision GPS. The 3000-nit display is the brightest we have ever shipped, and the action button is fully customizable.',
     'specs' => ['Case' => '49mm aerospace titanium', 'Display' => '1.92" LTPO AMOLED, 3000 nits', 'Battery' => '36h normal / 72h low power', 'Sensors' => 'ECG, SpO2, temperature, depth', 'GPS' => 'Dual-band L1 + L5', 'Water resistance' => '100m, EN13319 dive'],
     'images' => 'photo-1523275335684-37898b6baf30 photo-1546868871-7041f2a55e12 photo-1579586337278-3befd40fd17a'],

    ['slug' => 'chrono-watch-se', 'name' => 'Chrono Watch SE', 'brand' => 'Chrono', 'category' => 'wearables',
     'price' => 279, 'old_price' => null, 'rating' => 4.6, 'reviews' => 1755, 'stock' => 92, 'badge' => 'Best seller',
     'colors' => ['#1c1c1e', '#f2f2f7', '#30d158'],
     'short' => 'The essential smartwatch — fitness, sleep and notifications.',
     'description' => 'Chrono Watch SE brings core health tracking, crash detection and a crisp always-on display to a lightweight 40mm aluminum case. Two full days of battery with typical use.',
     'specs' => ['Case' => '40mm aluminum', 'Display' => '1.5" AMOLED, 1000 nits', 'Battery' => 'Up to 2 days', 'Sensors' => 'Heart rate, SpO2, accelerometer', 'GPS' => 'L1 single-band', 'Water resistance' => '50m'],
     'images' => 'photo-1546868871-7041f2a55e12 photo-1523275335684-37898b6baf30 photo-1579586337278-3befd40fd17a'],

    ['slug' => 'pulse-band-8', 'name' => 'Pulse Band 8', 'brand' => 'Pulse', 'category' => 'wearables',
     'price' => 79, 'old_price' => 99, 'rating' => 4.4, 'reviews' => 2890, 'stock' => 150, 'badge' => 'Deal',
     'colors' => ['#0a84ff', '#1c1c1e', '#ff375f'],
     'short' => 'Featherweight fitness band with 16-day battery life.',
     'description' => 'Pulse Band 8 tracks 150+ workout modes, sleep stages and stress — all from a 27g band that lasts up to 16 days per charge. A 1.6" AMOLED makes every glance effortless.',
     'specs' => ['Display' => '1.6" AMOLED', 'Battery' => '16 days typical', 'Sensors' => 'Heart rate, SpO2, sleep', 'Modes' => '150+ workout modes', 'Water resistance' => '50m', 'Weight' => '27 g'],
     'images' => 'photo-1557438159-51eec7a6c9e8 photo-1546868871-7041f2a55e12 photo-1523275335684-37898b6baf30'],

    ['slug' => 'vision-air-ring', 'name' => 'Vision Air Ring', 'brand' => 'Zenith', 'category' => 'wearables',
     'price' => 349, 'old_price' => null, 'rating' => 4.5, 'reviews' => 412, 'stock' => 39, 'badge' => 'New',
     'colors' => ['#1c1c1e', '#d6d3d1', '#bf5af2'],
     'short' => 'Smart ring for invisible, 24/7 health tracking.',
     'description' => 'Vision Air Ring packs heart rate, HRV, temperature and sleep tracking into a 4g titanium ring. Seven days of battery, no screen, no distractions — just insights in the app.',
     'specs' => ['Material' => 'Titanium, PVD coated', 'Battery' => '7 days', 'Sensors' => 'HR, HRV, SpO2, skin temp', 'Sizing' => 'US 6–13, 8 sizes', 'Water resistance' => '100m', 'Weight' => '4 g'],
     'images' => 'photo-1575378926881-b41a91f3c987 photo-1546868871-7041f2a55e12 photo-1557438159-51eec7a6c9e8'],

    ['slug' => 'apex-a7-mirrorless', 'name' => 'Apex A7 Mirrorless', 'brand' => 'Apex', 'category' => 'cameras',
     'price' => 2199, 'old_price' => 2399, 'rating' => 4.9, 'reviews' => 654, 'stock' => 9, 'badge' => 'Flagship',
     'colors' => ['#1c1c1e'],
     'short' => 'Full-frame 61MP stills, 8K video, 759-point AF.',
     'description' => 'The Apex A7 is a hybrid powerhouse: a 61MP full-frame sensor, 8K/30 internal video and an AI processor that recognizes subjects with 759 phase-detect points. In-body stabilization gives 8 stops of shake correction.',
     'specs' => ['Sensor' => '61MP full-frame BSI CMOS', 'Video' => '8K30 / 4K120 10-bit', 'AF' => '759-point phase detect, AI subject tracking', 'Stabilization' => 'In-body, 8 stops', 'Burst' => '10 fps mechanical / 30 fps electronic', 'Weight' => '658 g'],
     'images' => 'photo-1516035069371-29a1b244cc32 photo-1502920917128-1aa500764cbd photo-1519638831568-d9897f54ed69'],

    ['slug' => 'apex-r100', 'name' => 'Apex R100 Compact', 'brand' => 'Apex', 'category' => 'cameras',
     'price' => 899, 'old_price' => 999, 'rating' => 4.7, 'reviews' => 823, 'stock' => 24, 'badge' => null,
     'colors' => ['#1c1c1e', '#d6d3d1'],
     'short' => 'Pocketable 1-inch sensor compact with a bright f/1.8 lens.',
     'description' => 'Apex R100 brings serious image quality to a jacket pocket. The 20MP 1-inch stacked sensor and 24-120mm f/1.8-2.8 lens shoot gorgeous stills and 4K60 video, with a pop-up EVF for sunny days.',
     'specs' => ['Sensor' => '20MP 1" stacked CMOS', 'Lens' => '24-120mm f/1.8-2.8', 'Video' => '4K60 10-bit', 'EVF' => 'Pop-up 2.36M dot', 'Battery' => '260 shots', 'Weight' => '302 g'],
     'images' => 'photo-1502920917128-1aa500764cbd photo-1516035069371-29a1b244cc32 photo-1519638831568-d9897f54ed69'],

    ['slug' => 'sky-eye-4k-drone', 'name' => 'SkyEye 4K Drone', 'brand' => 'SkyEye', 'category' => 'cameras',
     'price' => 749, 'old_price' => 849, 'rating' => 4.6, 'reviews' => 377, 'stock' => 16, 'badge' => 'Deal',
     'colors' => ['#3a3a3c'],
     'short' => 'Foldable 4K/60 drone with 3-axis gimbal and 34-min flights.',
     'description' => 'SkyEye 4K folds to the size of a phone yet flies 34 minutes per battery. The 3-axis gimbal keeps 4K/60 HDR footage buttery smooth, and obstacle sensing in three directions makes it beginner-safe.',
     'specs' => ['Camera' => '4K60 HDR, 12MP stills', 'Gimbal' => '3-axis mechanical', 'Flight' => '34 min per battery', 'Range' => '10 km transmission', 'Sensors' => '3-direction obstacle sensing', 'Weight' => '249 g'],
     'images' => 'photo-1473968512647-3e447244af8f photo-1502920917128-1aa500764cbd photo-1516035069371-29a1b244cc32'],

    ['slug' => 'lumen-action-cam', 'name' => 'Lumen Action Cam', 'brand' => 'Lumen', 'category' => 'cameras',
     'price' => 349, 'old_price' => 399, 'rating' => 4.5, 'reviews' => 1108, 'stock' => 52, 'badge' => null,
     'colors' => ['#1c1c1e', '#0a84ff'],
     'short' => '5.3K60 action camera with horizon lock and waterproof body.',
     'description' => 'Lumen Action Cam shoots 5.3K60 with HyperSteady stabilization and 360° horizon lock. Waterproof to 10m without a case, with dual screens for effortless framing.',
     'specs' => ['Video' => '5.3K60 / 4K120', 'Stabilization' => 'HyperSteady 4.0 + horizon lock', 'Water resistance' => '10m, no case', 'Screens' => 'Front + rear touch', 'Battery' => '1720mAh, enduro mode', 'Weight' => '154 g'],
     'images' => 'photo-1519638831568-d9897f54ed69 photo-1502920917128-1aa500764cbd photo-1473968512647-3e447244af8f'],

    ['slug' => 'mech-type-75', 'name' => 'MechType 75 Keyboard', 'brand' => 'MechType', 'category' => 'accessories',
     'price' => 159, 'old_price' => 189, 'rating' => 4.8, 'reviews' => 1345, 'stock' => 71, 'badge' => 'Best seller',
     'colors' => ['#1c1c1e', '#f2f2f7'],
     'short' => 'Hot-swappable 75% mechanical keyboard with gasket mount.',
     'description' => 'MechType 75 is a gasket-mounted 75% board with hot-swap sockets, triple-mode connectivity (2.4G / BT5.1 / USB-C) and south-facing RGB. Pre-lubed linear switches sound and feel out of this world.',
     'specs' => ['Layout' => '75% (82 keys)', 'Mount' => 'Gasket, FR4 plate', 'Switches' => 'Hot-swap, pre-lubed linear', 'Connectivity' => '2.4GHz / Bluetooth 5.1 / USB-C', 'Battery' => '4000mAh', 'Keycaps' => 'PBT double-shot'],
     'images' => 'photo-1587829741301-dc798b83add3 photo-1618384887929-16ec33fab9ef photo-1595225476474-87563907a212'],

    ['slug' => 'glide-pro-mouse', 'name' => 'Glide Pro Mouse', 'brand' => 'MechType', 'category' => 'accessories',
     'price' => 99, 'old_price' => 119, 'rating' => 4.7, 'reviews' => 987, 'stock' => 105, 'badge' => null,
     'colors' => ['#1c1c1e', '#f2f2f7'],
     'short' => '58g ultralight wireless mouse with 26K optical sensor.',
     'description' => 'At 58 grams with zero honeycomb holes, Glide Pro pairs an esports-grade 26,000 DPI sensor with 90-hour battery life and optical switches rated for 100M clicks.',
     'specs' => ['Weight' => '58 g', 'Sensor' => '26,000 DPI optical', 'Switches' => 'Optical, 100M clicks', 'Polling' => '4000Hz wireless', 'Battery' => '90 hours', 'Connectivity' => '2.4GHz / USB-C wired'],
     'images' => 'photo-1527864550417-7fd91fc51a46 photo-1587829741301-dc798b83add3 photo-1615663245857-ac93bb7c39e7'],

    ['slug' => 'voltcore-140w-charger', 'name' => 'VoltCore 140W GaN Charger', 'brand' => 'VoltCore', 'category' => 'accessories',
     'price' => 69, 'old_price' => 89, 'rating' => 4.6, 'reviews' => 2210, 'stock' => 200, 'badge' => 'Deal',
     'colors' => ['#1c1c1e', '#f2f2f7'],
     'short' => 'Three ports, 140W total, smaller than your laptop brick.',
     'description' => 'VoltCore 140W uses third-gen GaN to charge a 16" laptop at full speed while topping up a phone and earbuds — all from a charger that fits in your palm.',
     'specs' => ['Output' => '140W total (PD 3.1)', 'Ports' => '2× USB-C + 1× USB-A', 'Single port max' => '140W USB-C 1', 'Size' => '68 × 68 × 32 mm', 'Extras' => 'Foldable plug, travel ready', 'Weight' => '215 g'],
     'images' => 'photo-1609091839311-d5365f9ff1c5 photo-1583863788434-e58a36330cf0 photo-1609091839311-d5365f9ff1c5'],

    ['slug' => 'vision-xr-headset', 'name' => 'Vision XR Headset', 'brand' => 'Zenith', 'category' => 'accessories',
     'price' => 499, 'old_price' => 549, 'rating' => 4.4, 'reviews' => 388, 'stock' => 14, 'badge' => 'New',
     'colors' => ['#f2f2f7', '#1c1c1e'],
     'short' => 'Standalone mixed-reality headset with 4K per eye.',
     'description' => 'Vision XR blends digital content into your room with 4K micro-OLED displays, full-color passthrough and hand tracking. No PC, no base stations — just put it on.',
     'specs' => ['Displays' => '2× 4K micro-OLED, 90Hz', 'Tracking' => 'Inside-out, hand + controller', 'Passthrough' => 'Full-color, low latency', 'Storage' => '256GB', 'Battery' => '2.5h (external pack)', 'Weight' => '515 g'],
     'images' => 'photo-1622979135225-d2ba269cf1ac photo-1617802690992-15d93263d3a9 photo-1622979135225-d2ba269cf1ac'],
];

/** Resolve image IDs to full URLs after definition. */
foreach (SEED_PRODUCTS as &$p) {
    $ids = explode(' ', $p['images']);
    $p['images'] = seed_gallery($ids[0], array_slice($ids, 1));
}
unset($p);
