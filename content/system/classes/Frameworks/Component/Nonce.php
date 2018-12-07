<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/23
 * Time: 13:18
 */

namespace Ecjia\System\Frameworks\Component;

use RC_Hook;

class Nonce
{

    /**
     * Creates a cryptographic token tied to a specific action, user, user session,
     * and window of time.
     *
     * @since 2.0.3
     * @since 4.0.0 Session tokens were integrated with nonce creation
     *
     * @param string|int $action Scalar value to add context to the nonce.
     * @return string The token.
     */
    public function create_nonce($action = -1)
    {
        $user = wp_get_current_user();
        $uid = (int) $user->ID;
        if ( ! $uid ) {
            /** This filter is documented in wp-includes/pluggable.php */
            $uid = RC_Hook::apply_filters( 'nonce_user_logged_out', $uid, $action );
        }

        $token = wp_get_session_token();
        $i = $this->nonce_tick();

        return substr( wp_hash( $i . '|' . $action . '|' . $uid . '|' . $token, 'nonce' ), -12, 10 );
    }


    /**
     * Verify that correct nonce was used with time limit.
     *
     * The user is given an amount of time to use the token, so therefore, since the
     * UID and $action remain the same, the independent variable is the time.
     *
     * @since 2.0.3
     *
     * @param string     $nonce  Nonce that was used in the form to verify
     * @param string|int $action Should give context to what is taking place and be the same when nonce was created.
     * @return false|int False if the nonce is invalid, 1 if the nonce is valid and generated between
     *                   0-12 hours ago, 2 if the nonce is valid and generated between 12-24 hours ago.
     */
    public function verify_nonce( $nonce, $action = -1 )
    {
        $nonce = (string) $nonce;
        $user = wp_get_current_user();
        $uid = (int) $user->ID;
        if ( ! $uid ) {
            /**
             * Filters whether the user who generated the nonce is logged out.
             *
             * @since 3.5.0
             *
             * @param int    $uid    ID of the nonce-owning user.
             * @param string $action The nonce action.
             */
            $uid = RC_Hook::apply_filters( 'nonce_user_logged_out', $uid, $action );
        }

        if ( empty( $nonce ) ) {
            return false;
        }

        $token = wp_get_session_token();
        $i = $this->nonce_tick();

        // Nonce generated 0-12 hours ago
        $expected = substr( wp_hash( $i . '|' . $action . '|' . $uid . '|' . $token, 'nonce'), -12, 10 );
        if ( hash_equals( $expected, $nonce ) ) {
            return 1;
        }

        // Nonce generated 12-24 hours ago
        $expected = substr( wp_hash( ( $i - 1 ) . '|' . $action . '|' . $uid . '|' . $token, 'nonce' ), -12, 10 );
        if ( hash_equals( $expected, $nonce ) ) {
            return 2;
        }

        /**
         * Fires when nonce verification fails.
         *
         * @since 4.4.0
         *
         * @param string     $nonce  The invalid nonce.
         * @param string|int $action The nonce action.
         * @param WP_User    $user   The current user object.
         * @param string     $token  The user's session token.
         */
        RC_Hook::do_action( 'ecjia_verify_nonce_failed', $nonce, $action, $user, $token );

        // Invalid nonce
        return false;
    }


    /**
     * Get the time-dependent variable for nonce creation.
     *
     * A nonce has a lifespan of two ticks. Nonces in their second tick may be
     * updated, e.g. by autosave.
     *
     * @since 2.5.0
     *
     * @return float Float value rounded up to the next highest integer.
     */
    public function nonce_tick()
    {
        /**
         * Filters the lifespan of nonces in seconds.
         *
         * @since 2.5.0
         *
         * @param int $lifespan Lifespan of nonces in seconds. Default 86,400 seconds, or one day.
         */
        $nonce_life = RC_Hook::apply_filters( 'nonce_life', DAY_IN_SECONDS );

        return ceil(time() / ( $nonce_life / 2 ));
    }




}