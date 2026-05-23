/**
 * bouquetta.js
 * Main interactive JavaScript for Bouquetta
 */

'use strict';

// =====================================================
// FLOWER DATA
// =====================================================
const FLOWERS = [
  { id: 'anemone',    name: 'Anemone',    meaning: 'Anticipation & protection', image: '/images/flowers/anemonen.webp'    },
  { id: 'carnation',  name: 'Carnation',  meaning: 'Love & admiration',          image: '/images/flowers/carnationn.webp'  },
  { id: 'daisy',      name: 'Daisy',      meaning: 'Innocence & purity',         image: '/images/flowers/daisyn.webp'      },
  { id: 'rose',       name: 'Rose',       meaning: 'Deep love',                  image: '/images/flowers/rosen.webp'       },
  { id: 'sunflower',  name: 'Sunflower',  meaning: 'Adoration & loyalty',        image: '/images/flowers/sunflowern.webp'  },
  { id: 'tulip',      name: 'Tulip',      meaning: 'Perfect love',               image: '/images/flowers/tulipn.webp'      },
  { id: 'orchid',     name: 'Orchid',     meaning: 'Luxury & elegance',          image: '/images/flowers/orchidn.webp'     },
  { id: 'peony',      name: 'Peony',      meaning: 'Romance & prosperity',       image: '/images/flowers/peonyn.webp'      },
  { id: 'lily',       name: 'Lily',       meaning: 'Purity of heart',            image: '/images/flowers/lilyns.webp'      },
  { id: 'ranunculus', name: 'Ranunculus', meaning: 'New beginnings',             image: '/images/flowers/ranunculusn.webp' },
];

// =====================================================
// STATE
// =====================================================
let bouquet = [];
const MAX_FLOWERS = 8;

// =====================================================
// DOM REFS
// =====================================================
const $ = id => document.getElementById(id);

const bloomsGrid     = $('bloomsGrid');
const flowerPalette  = $('flowerPalette');
const bouquetFlowers = $('bouquetFlowers');
const emptyMsg       = $('emptyMsg');
const bouquetWrap    = $('bouquetWrap');
const countBadge     = $('countBadge');
const clearBtn       = $('clearBtn');
const orderBtn       = $('orderBtn');
const toast          = $('toast');

// =====================================================
// RENDER BLOOMS GRID
// =====================================================
function renderBloomsGrid() {
  if (!bloomsGrid) return;
  bloomsGrid.innerHTML = FLOWERS.map(f => `
    <div class="collection-card" onclick="addFromCollection('${f.id}')">
      <div style="width:80px;height:80px;margin:auto;display:flex;align-items:center;justify-content:center;">
        <img src="${f.image}" alt="${f.name}" style="width:100%;height:100%;object-fit:contain;">
      </div>
      <div>${f.name}</div>
    </div>
  `).join('');
}

// =====================================================
// RENDER PALETTE
// =====================================================
function renderPalette() {
  if (!flowerPalette) return;
  flowerPalette.innerHTML = FLOWERS.map(f => `
    <div class="flower-chip" onclick="toggleFlower('${f.id}')" id="chip-${f.id}">
      <div>
        <img src="${f.image}" alt="${f.name}" style="width:52px;height:52px;object-fit:contain;">
      </div>
      <div>${f.name}</div>
    </div>
  `).join('');
}

// =====================================================
// SLOT POSISI BUNGA — dx/dy relatif terhadap cx,cy
// =====================================================
const SLOT_PATTERNS = {
  1: [
    { dx:  0, dy:  0, size: 82, z: 10 },
  ],
  2: [
    { dx:-26, dy:  5, size: 74, z:  9 },
    { dx: 26, dy:  5, size: 74, z:  9 },
  ],
  3: [
    { dx:  0, dy:-20, size: 72, z: 10 },
    { dx:-32, dy: 12, size: 68, z:  8 },
    { dx: 32, dy: 12, size: 68, z:  8 },
  ],
  4: [
    { dx:  0, dy:-22, size: 72, z: 10 },
    { dx:-34, dy:  8, size: 66, z:  8 },
    { dx: 34, dy:  8, size: 66, z:  8 },
    { dx:  0, dy: 32, size: 64, z: 12 },
  ],
  5: [
    { dx:  0, dy:-26, size: 70, z: 10 },
    { dx:-36, dy: -4, size: 66, z:  8 },
    { dx: 36, dy: -4, size: 66, z:  8 },
    { dx:-18, dy: 26, size: 62, z: 11 },
    { dx: 18, dy: 26, size: 62, z: 11 },
  ],
  6: [
    { dx:  0, dy:-28, size: 70, z: 10 },
    { dx:-36, dy: -6, size: 66, z:  8 },
    { dx: 36, dy: -6, size: 66, z:  8 },
    { dx:-18, dy: 24, size: 62, z: 11 },
    { dx: 18, dy: 24, size: 62, z: 11 },
    { dx:  0, dy: 44, size: 60, z: 13 },
  ],
  7: [
    { dx:  0, dy:-30, size: 70, z: 10 },
    { dx:-36, dy: -8, size: 66, z:  8 },
    { dx: 36, dy: -8, size: 66, z:  8 },
    { dx:-20, dy: 22, size: 63, z: 11 },
    { dx: 20, dy: 22, size: 63, z: 11 },
    { dx:-10, dy: 46, size: 60, z: 13 },
    { dx: 10, dy: 46, size: 60, z: 13 },
  ],
  8: [
    { dx:  0, dy:-34, size: 70, z: 10 },
    { dx:-36, dy:-10, size: 66, z:  8 },
    { dx: 36, dy:-10, size: 66, z:  8 },
    { dx:-20, dy: 20, size: 64, z: 11 },
    { dx: 20, dy: 20, size: 64, z: 11 },
    { dx:  0, dy: 42, size: 62, z: 13 },
    { dx:-36, dy: 16, size: 56, z:  7 },
    { dx: 36, dy: 16, size: 56, z:  7 },
  ],
};

// =====================================================
// LEAF HELPERS
// =====================================================

// Buat SVG layer absolut seukuran container
function makeSVGLayer(zIndex, CW, CH) {
  const s = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
  s.setAttribute('viewBox', `0 0 ${CW} ${CH}`);
  s.style.cssText = `
    position:absolute;top:0;left:0;
    width:${CW}px;height:${CH}px;
    pointer-events:none;z-index:${zIndex};
  `;
  return s;
}

// Gambar daun organik melengkung
// Kunci: cpx jauh ke samping → daun melengkung keluar lalu jatuh
function drawLeaf(svg, x1, y1, cpx, cpy, x2, y2, bulge, fill, op = 0.92) {
  const dx  = x2 - x1, dy = y2 - y1;
  const len = Math.sqrt(dx * dx + dy * dy) || 1;
  const nx  = -dy / len * bulge;
  const ny  =  dx / len * bulge;

  const p = document.createElementNS('http://www.w3.org/2000/svg', 'path');
  p.setAttribute('d', `
    M ${x1} ${y1}
    Q ${cpx + nx} ${cpy + ny} ${x2} ${y2}
    Q ${cpx - nx} ${cpy - ny} ${x1} ${y1} Z
  `);
  p.setAttribute('fill', fill);
  p.setAttribute('opacity', op);
  svg.appendChild(p);

  // tulang daun
  const v = document.createElementNS('http://www.w3.org/2000/svg', 'path');
  v.setAttribute('d', `M ${x1} ${y1} Q ${cpx} ${cpy} ${x2} ${y2}`);
  v.setAttribute('fill', 'none');
  v.setAttribute('stroke', 'rgba(255,255,255,0.2)');
  v.setAttribute('stroke-width', '0.8');
  svg.appendChild(v);
}

// Gambar helai rumput/lavender tipis melengkung
function drawGrass(svg, x1, y1, cpx, cpy, x2, y2, w, stroke, op = 0.84) {
  const p = document.createElementNS('http://www.w3.org/2000/svg', 'path');
  p.setAttribute('d', `M ${x1} ${y1} Q ${cpx} ${cpy} ${x2} ${y2}`);
  p.setAttribute('fill', 'none');
  p.setAttribute('stroke', stroke);
  p.setAttribute('stroke-width', w);
  p.setAttribute('stroke-linecap', 'round');
  p.setAttribute('opacity', op);
  svg.appendChild(p);
}

// =====================================================
// RENDER BOUQUET
// =====================================================
function renderBouquet() {
  if (!bouquetFlowers) return;

  if (countBadge) {
    countBadge.textContent = `${bouquet.length} / ${MAX_FLOWERS}`;
  }

  if (bouquet.length === 0) {
    bouquetFlowers.innerHTML = '';
    if (emptyMsg)    emptyMsg.style.display    = 'flex';
    if (bouquetWrap) bouquetWrap.style.display = 'none';
    return;
  }

  if (emptyMsg)    emptyMsg.style.display    = 'none';
  if (bouquetWrap) bouquetWrap.style.display = 'block';

  // Ukuran container aktual
  const CW = bouquetFlowers.offsetWidth  || 308;
  const CH = bouquetFlowers.offsetHeight || 420;

  // Pusat cluster bunga — sepertiga atas container
  const cx = CW / 2;
  const cy = CH * 0.36;

  // Pangkal semua daun — tepat di bawah cluster bunga
  const rx = cx;
  const ry = cy + 55;

  // Kosongkan container
  bouquetFlowers.innerHTML = '';

  // ─────────────────────────────────────────────────
  // LAYER 1 — SVG DAUN BELAKANG  (z-index: 1)
  // cpx jauh ke samping agar daun melengkung keluar
  // lalu ujung (x2,y2) jatuh ke bawah → efek menjuntai
  // ─────────────────────────────────────────────────
  const svgBack = makeSVGLayer(1, CW, CH);
  bouquetFlowers.appendChild(svgBack);

  // Daun lebar kiri-luar
  drawLeaf(svgBack,
    rx, ry,
    rx - 130, ry + 28,
    rx - 148, ry + 198,
    28, '#1a5c35', 0.93
  );
  // Daun lebar kanan-luar
  drawLeaf(svgBack,
    rx, ry,
    rx + 133, ry + 25,
    rx + 150, ry + 192,
    27, '#1e6b3e', 0.92
  );

  // Daun panjang kiri — melengkung dalam, ujung jauh ke bawah
  drawLeaf(svgBack,
    rx, ry,
    rx - 112, ry + 55,
    rx - 98,  ry + 308,
    16, '#155228', 0.90
  );
  // Daun panjang kanan
  drawLeaf(svgBack,
    rx, ry,
    rx + 115, ry + 50,
    rx + 100, ry + 302,
    15, '#0f4228', 0.89
  );

  // Daun sedang kiri-tengah
  drawLeaf(svgBack,
    rx, ry,
    rx - 78, ry + 42,
    rx - 62, ry + 238,
    13, '#236b42', 0.88
  );
  // Daun sedang kanan-tengah
  drawLeaf(svgBack,
    rx, ry,
    rx + 80, ry + 40,
    rx + 65, ry + 232,
    12, '#185230', 0.87
  );

  // Daun hampir horizontal kiri — menyamping lebar
  drawLeaf(svgBack,
    rx, ry,
    rx - 158, ry - 18,
    rx - 182, ry + 85,
    18, '#0d3c24', 0.88
  );
  // Daun hampir horizontal kanan
  drawLeaf(svgBack,
    rx, ry,
    rx + 160, ry - 20,
    rx + 185, ry + 80,
    17, '#0f4028', 0.87
  );

  // Rumput hijau kiri
  drawGrass(svgBack,
    rx - 4, ry,  rx - 102, ry + 48,  rx - 90,  ry + 312,
    4.5, '#2a7a4c', 0.84
  );
  drawGrass(svgBack,
    rx - 6, ry,  rx - 142, ry + 18,  rx - 158, ry + 255,
    3.2, '#2a7a4c', 0.76
  );
  // Rumput hijau kanan
  drawGrass(svgBack,
    rx + 4, ry,  rx + 104, ry + 44,  rx + 92,  ry + 306,
    4.5, '#236b42', 0.84
  );
  drawGrass(svgBack,
    rx + 6, ry,  rx + 145, ry + 16,  rx + 160, ry + 248,
    3.2, '#236b42', 0.76
  );
  // Rumput tengah jatuh lembut
  drawGrass(svgBack,
    rx, ry,  rx + 18, ry + 98,  rx + 8, ry + 342,
    3.5, '#1e6b3e', 0.75
  );

  // Lavender kiri
  drawGrass(svgBack,
    rx - 5, ry,  rx - 120, ry + 36,  rx - 105, ry + 282,
    2.8, '#9887b0', 0.70
  );
  // Lavender kanan
  drawGrass(svgBack,
    rx + 5, ry,  rx + 122, ry + 33,  rx + 108, ry + 275,
    2.5, '#8b7ea0', 0.65
  );

  // ─────────────────────────────────────────────────
  // LAYER 2 — BUNGA  (z-index: 10)
  // ─────────────────────────────────────────────────
  const count = bouquet.length;
  const slots = SLOT_PATTERNS[count] || SLOT_PATTERNS[8];

  const flowerLayer = document.createElement('div');
  flowerLayer.style.cssText = `
    position:absolute;top:0;left:0;
    width:${CW}px;height:${CH}px;
    z-index:10;
  `;
  bouquetFlowers.appendChild(flowerLayer);

  slots.forEach((slot, index) => {
    const id = bouquet[index];
    if (!id) return;

    const f   = FLOWERS.find(fl => fl.id === id);
    const bx  = cx + slot.dx - slot.size / 2;
    const by  = cy + slot.dy - slot.size / 2;
    const rot = (slot.dx / (CW / 2)) * 7;

    const el = document.createElement('div');
    el.className = 'bouquet-flower-item';
    el.style.cssText = `
      position:absolute;
      left:${bx}px;
      top:${by}px;
      width:${slot.size}px;
      height:${slot.size}px;
      z-index:${slot.z};
      animation:flowerPop 0.45s cubic-bezier(0.34,1.56,0.64,1) ${index * 0.06}s both;
    `;

    el.innerHTML = `
      <img
        src="${f.image}"
        alt="${f.name}"
        style="
          width:100%;height:100%;
          object-fit:contain;
          transform:rotate(${rot}deg);
          filter:drop-shadow(0 5px 10px rgba(0,0,0,0.2));
          user-select:none;pointer-events:none;
        "
      >
      <button class="remove-btn" onclick="removeFlower(${index})">✕</button>
    `;

    flowerLayer.appendChild(el);
  });

  // ─────────────────────────────────────────────────
  // LAYER 3 — SVG DAUN DEPAN  (z-index: 22)
  // Tipis, sedikit overlap di atas bunga bawah
  // ─────────────────────────────────────────────────
  const svgFront = makeSVGLayer(22, CW, CH);
  bouquetFlowers.appendChild(svgFront);

  // Daun depan kiri
  drawLeaf(svgFront,
    rx, ry,  rx - 65, ry + 26,  rx - 58, ry + 168,
    11, '#236b42', 0.87
  );
  // Daun depan kanan
  drawLeaf(svgFront,
    rx, ry,  rx + 67, ry + 23,  rx + 60, ry + 162,
    10, '#1a5c35', 0.86
  );

  // Rumput depan kiri
  drawGrass(svgFront,
    rx - 5, ry,  rx - 84, ry + 33,  rx - 74, ry + 215,
    3.8, '#2a7a4c', 0.80
  );
  // Rumput depan kanan
  drawGrass(svgFront,
    rx + 5, ry,  rx + 86, ry + 30,  rx + 76, ry + 208,
    3.5, '#236b42', 0.78
  );

  // Lavender depan kiri
  drawGrass(svgFront,
    rx - 5, ry,  rx - 96, ry + 20,  rx - 108, ry + 186,
    2.6, '#9887b0', 0.66
  );
  // Lavender depan kanan
  drawGrass(svgFront,
    rx + 5, ry,  rx + 98, ry + 18,  rx + 110, ry + 180,
    2.3, '#8b7ea0', 0.62
  );
}

// =====================================================
// TOGGLE FLOWER
// =====================================================
window.toggleFlower = function(id) {
  const chip  = $(`chip-${id}`);
  const index = bouquet.indexOf(id);

  if (index !== -1) {
    bouquet.splice(index, 1);
    if (chip) chip.classList.remove('selected');
  } else {
    if (bouquet.length >= MAX_FLOWERS) {
      showToast('Bouquet full!');
      return;
    }
    bouquet.push(id);
    if (chip) chip.classList.add('selected');
    showToast(`${id} added ✨`);
  }

  renderBouquet();
};

// =====================================================
// ADD FROM COLLECTION
// =====================================================
window.addFromCollection = function(id) {
  if (bouquet.includes(id)) return;

  if (bouquet.length >= MAX_FLOWERS) {
    showToast('Bouquet full!');
    return;
  }

  bouquet.push(id);

  const chip = $(`chip-${id}`);
  if (chip) chip.classList.add('selected');

  renderBouquet();
};

// =====================================================
// REMOVE FLOWER
// =====================================================
window.removeFlower = function(index) {
  const id   = bouquet[index];
  bouquet.splice(index, 1);

  const chip = $(`chip-${id}`);
  if (chip) chip.classList.remove('selected');

  renderBouquet();
};

// =====================================================
// CLEAR
// =====================================================
if (clearBtn) {
  clearBtn.addEventListener('click', () => {
    bouquet = [];
    document.querySelectorAll('.flower-chip').forEach(c => c.classList.remove('selected'));
    renderBouquet();
    showToast('Bouquet cleared 🌿');
  });
}

// =====================================================
// ORDER
// =====================================================
if (orderBtn) {
  orderBtn.addEventListener('click', () => {
    if (bouquet.length === 0) {
      showToast('Add flowers first!');
      return;
    }
    showToast('Bouquet ordered 💐');
  });
}

// =====================================================
// TOAST
// =====================================================
let toastTimer;

function showToast(message) {
  if (!toast) return;
  toast.textContent = message;
  toast.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => toast.classList.remove('show'), 2500);
}

// =====================================================
// INIT
// =====================================================
function init() {
  renderBloomsGrid();
  renderPalette();
  renderBouquet();
}

document.addEventListener('DOMContentLoaded', init);