window.onload = function() {
  // URL del contrato según el entorno
  const isUniversityServer = window.location.pathname.includes('/22030344/');
  const contractUrl = isUniversityServer 
      ? '/22030344/api/public/openapi.yaml' 
      : '/api/public/openapi.yaml';

  window.ui = SwaggerUIBundle({
    url: contractUrl,
    dom_id: '#swagger-ui',
    deepLinking: true,
    presets: [
      SwaggerUIBundle.presets.apis,
      SwaggerUIStandalonePreset
    ],
    plugins: [
      SwaggerUIBundle.plugins.DownloadUrl
    ],
    layout: "StandaloneLayout",
    persistAuthorization: true
  });
};
