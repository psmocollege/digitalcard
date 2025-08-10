<?php

namespace Drupal\dynamic_pwa_manifest\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;

class ManifestController extends ControllerBase {

  protected $requestStack;

  public function __construct(RequestStack $request_stack) {
    $this->requestStack = $request_stack;
  }

  public function manifest() {
    $request = $this->requestStack->getCurrentRequest();
    $current_path = $request->getPathInfo();
    $base_url = \Drupal::request()->getSchemeAndHttpHost();

    // Initialize start_url with default '/'
    $start_url = $base_url . '/';

    // Extract the node ID from the path, assuming a standard URL pattern like '/node/{nid}'
    if (preg_match('/^\/node\/(\d+)$/', $current_path, $matches)) {
      $node_id = $matches[1];
      $node = Node::load($node_id);

      if ($node) {
        // Generate the full URL for the node
        $start_url = Url::fromRoute('entity.node.canonical', ['node' => $node_id], ['absolute' => TRUE])->toString();
      }
    } else {
      // For non-node paths, use the current path
      $start_url = $base_url . $current_path;
    }

    // Define your dynamic manifest properties based on the node URL.
    $manifest = [
      'name' => 'Dynamic PWA App',
      'short_name' => 'PWA',
      'start_url' => $start_url,
      'display' => 'standalone',
      'background_color' => '#ffffff',
      'theme_color' => '#000000',
      'icons' => [
        [
          'src' => '/path/to/icon.png',
          'sizes' => '192x192',
          'type' => 'image/png',
        ],
      ],
    ];

    return new JsonResponse($manifest);
  }
}
