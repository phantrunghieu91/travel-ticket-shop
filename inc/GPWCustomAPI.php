<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Custom Rest API controller
 */
class GPWCustomAPI {
  public function __construct() {
    add_action( 'rest_api_init', [ $this, 'register_route' ] );
  }
  public function register_route() {
    register_rest_route( 'gpw/v1', '/company_info', [
      'methods' => 'GET',
      'callback' => [ $this, 'get_company_info' ],
      'permission_callback' => [ $this, 'permission_check' ]
    ]);
  }
  public function permission_check( $request ) {
    $apiKey = $request->get_header( 'X-API-KEY' );
    $validApiKey = 'GPW_KEY_23_TCV';
    return $apiKey === $validApiKey;
  }
  public function get_company_info() {
    $company_info = [
      'address' => get_field('address', 'company_info'),
      'phone' => get_field('phone_number', 'company_info'),
      'email' => get_field('email', 'company_info'),
    ];
    return rest_ensure_response( $company_info );
  }
}
