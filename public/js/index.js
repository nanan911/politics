document.getElementById('login').addEventListener('click', function() {
  document.querySelector('.container').classList.remove('active');
});

document.getElementById('register').addEventListener('click', function() {
  document.querySelector('.container').classList.add('active');
});

// src/api/index.js
export const fetchTrendData = async (params) => {
  const response = await fetch('/api/trend-data', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify(params),
  });
  return response.json();
};

export const fetchColumnData = async (params) => {
  const response = await fetch('/api/column-data', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify(params),
  });
  return response.json();
};

export const fetchBubbleData = async (params) => {
  const response = await fetch('/api/bubble-data', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify(params),
  });
  return response.json();
};

export const fetchPackedBubbleData = async (params) => {
  const response = await fetch('/api/packed-bubble-data', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify(params),
  });
  return response.json();
};
