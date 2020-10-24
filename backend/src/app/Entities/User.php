<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Support\Arrayable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends Authenticatable implements Arrayable, JWTSubject
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="email", type="string",length=80, nullable=false)
     */
    protected $email;

    /**
     * @ORM\Column(name="password", type="string",length=80, nullable=false)
     */
    protected $password;

    /**
     * @ORM\Column(name="first_name", type="string",length=80, nullable=true)
     */
    protected $firstName;

    /**
     * @ORM\Column(name="last_name", type="string",length=80, nullable=true)
     */
    protected $lastName;

    /**
     * @ORM\Column(name="remember_token", type="string",length=100, nullable=true)
     */
    protected $rememberToken;


    public function toArray() {
        $output = [];

        foreach (get_class_vars(get_class($this)) as $propName => $propDefaultValue) {
            if (in_array($propName, ['password'])) {
                continue;
            }

            $output[$propName] = $this->{$propName};
        }

        return $output;
    }

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getId();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = Hash::make($password);

        return $this;
    }

    public function auth( $password ) {
        return Hash::check( $password, $this->password );
    }
 
    /**
     * Get the value of firstName
     */ 
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @return  self
     */ 
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     */ 
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */ 
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }
}