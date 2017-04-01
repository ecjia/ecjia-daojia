<?php namespace Royalcms\Component\Auth;

interface UserProviderInterface {

	/**
	 * Retrieve a user by their unique identifier.
	 *
	 * @param  mixed  $identifier
	 * @return \Royalcms\Component\Auth\UserInterface|null
	 */
	public function retrieveById($identifier);

	/**
	 * Retrieve a user by by their unique identifier and "remember me" token.
	 *
	 * @param  mixed  $identifier
	 * @param  string  $token
	 * @return \Royalcms\Component\Auth\UserInterface|null
	 */
	public function retrieveByToken($identifier, $token);

	/**
	 * Update the "remember me" token for the given user in storage.
	 *
	 * @param  \Royalcms\Component\Auth\UserInterface  $user
	 * @param  string  $token
	 * @return void
	 */
	public function updateRememberToken(UserInterface $user, $token);

	/**
	 * Retrieve a user by the given credentials.
	 *
	 * @param  array  $credentials
	 * @return \Royalcms\Component\Auth\UserInterface|null
	 */
	public function retrieveByCredentials(array $credentials);

	/**
	 * Validate a user against the given credentials.
	 *
	 * @param  \Royalcms\Component\Auth\UserInterface  $user
	 * @param  array  $credentials
	 * @return bool
	 */
	public function validateCredentials(UserInterface $user, array $credentials);

}
