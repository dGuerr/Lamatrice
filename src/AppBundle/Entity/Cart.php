<?php

namespace AppBundle\Entity;

use AppBundle\Enum\StatusTypeEnum;
use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="cart")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CartRepository")
 */
class Cart
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Défini si le panier est validé (que l'utilisateur a payé le panier).
     * @var bool
     *
     * @ORM\Column(name="validated", type="boolean")
     */
    private $validated;

    /**
     * Utilisateur qui a effectué la commande.
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="carts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * Représente les produits dans le panier.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CartProduct", mappedBy="cart", cascade={"remove"})
     */
    private $cartProducts;

    /**
     * Statut du panier : Non Traité | En Cours De Traitement | Traité.
     * @var string
     * @ORM\Column(name="status", type="string", length=255, nullable=false)
     */
    private $status;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set validated
     *
     * @param boolean $validated
     *
     * @return Cart
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Get validated
     *
     * @return bool
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Cart
     */
    public function setUser(\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cartProducts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add cartProduct
     *
     * @param \AppBundle\Entity\CartProduct $cartProduct
     *
     * @return Cart
     */
    public function addCartProduct(\AppBundle\Entity\CartProduct $cartProduct)
    {
        $this->cartProducts[] = $cartProduct;

        return $this;
    }

    /**
     * Remove cartProduct
     *
     * @param \AppBundle\Entity\CartProduct $cartProduct
     */
    public function removeCartProduct(\AppBundle\Entity\CartProduct $cartProduct)
    {
        $this->cartProducts->removeElement($cartProduct);
    }

    /**
     * Get cartProducts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCartProducts()
    {
        return $this->cartProducts;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Cart
     */
    public function setStatus($status)
    {
        if (!in_array($status, StatusTypeEnum::getAvailableTypes())) {
            throw new \InvalidArgumentException("Status inconnu");
        }

        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
