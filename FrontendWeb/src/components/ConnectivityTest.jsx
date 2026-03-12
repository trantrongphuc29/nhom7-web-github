import React, { useState } from 'react';
import { API_ENDPOINTS } from '../config/api';

const ConnectivityTest = () => {
  const [testResults, setTestResults] = useState({});
  const [testing, setTesting] = useState(false);

  const testEndpoint = async (name, url) => {
    try {
      console.log(`Testing ${name}: ${url}`);
      const response = await fetch(url, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        },
        mode: 'cors'
      });
      
      if (response.ok) {
        const data = await response.json();
        return { status: 'success', data, statusCode: response.status };
      } else {
        return { status: 'error', error: `HTTP ${response.status}`, statusCode: response.status };
      }
    } catch (error) {
      return { status: 'failed', error: error.message, type: error.name };
    }
  };

  const runTests = async () => {
    setTesting(true);
    const results = {};
    
    // Test basic connectivity
    results.testEndpoint = await testEndpoint('Test Endpoint', 'https://nhom7-web-backend.gt.tc/api/test.php');
    results.banners = await testEndpoint('Banners API', API_ENDPOINTS.BANNERS);
    results.products = await testEndpoint('Products API', API_ENDPOINTS.PRODUCTS);
    
    setTestResults(results);
    setTesting(false);
  };

  return (
    <div className="p-4 bg-gray-100 rounded-lg mb-4">
      <h3 className="text-lg font-bold mb-2">Backend Connectivity Test</h3>
      <button 
        onClick={runTests} 
        disabled={testing}
        className="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 disabled:opacity-50"
      >
        {testing ? 'Testing...' : 'Run Connectivity Test'}
      </button>
      
      {Object.keys(testResults).length > 0 && (
        <div className="mt-4">
          <h4 className="font-semibold mb-2">Test Results:</h4>
          {Object.entries(testResults).map(([key, result]) => (
            <div key={key} className="mb-2 p-2 border rounded">
              <strong>{key}:</strong>
              <span className={`ml-2 px-2 py-1 rounded text-sm ${
                result.status === 'success' ? 'bg-green-200 text-green-800' :
                result.status === 'error' ? 'bg-yellow-200 text-yellow-800' :
                'bg-red-200 text-red-800'
              }`}>
                {result.status}
              </span>
              {result.error && <div className="text-red-600 text-sm mt-1">Error: {result.error}</div>}
              {result.statusCode && <div className="text-gray-600 text-sm">Status: {result.statusCode}</div>}
            </div>
          ))}
        </div>
      )}
    </div>
  );
};

export default ConnectivityTest;