<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 * fields= {"mail"},
 * message= "L'email est déjà utilisé !",
 * fields={"username"},
 * message="Ce nom d'utilisateur est déjà pris."
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website_url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bio;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     */
    private $mail;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $phone_number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thumbnail;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_post;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="6")
     */
    private $password;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_saved_posts;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_folowers;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_subscription;

    /**
     * @ORM\Column(type="date")
     */
    private $registrationDate;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="user")
     */
    private $post;

    /**
     * @ORM\OneToMany(targetEntity=Followers::class, mappedBy="user")
     */
    private $followers;

    /**
     * @ORM\OneToMany(targetEntity=SavedPost::class, mappedBy="user")
     */
    private $saved_post;

    /**
     * @ORM\OneToMany(targetEntity=Subscription::class, mappedBy="user")
     */
    private $subscription;

    /**
     * @ORM\Column(type="date")
     */
    private $dob;

    public function __construct()
    {
        $this->post = new ArrayCollection();
        $this->followers = new ArrayCollection();
        $this->saved_post = new ArrayCollection();
        $this->subscription = new ArrayCollection();
        $this->registrationDate = new \DateTime('now');
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getWebsiteUrl(): ?string
    {
        return $this->website_url;
    }

    public function setWebsiteUrl(?string $website_url): self
    {
        $this->website_url = $website_url;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPhoneNumber(): ?float
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?float $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getIdPost(): ?int
    {
        return $this->id_post;
    }

    public function setIdPost(?int $id_post): self
    {
        $this->id_post = $id_post;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getIdSavedPosts(): ?int
    {
        return $this->id_saved_posts;
    }

    public function setIdSavedPosts(?int $id_saved_posts): self
    {
        $this->id_saved_posts = $id_saved_posts;

        return $this;
    }

    public function getIdFolowers(): ?int
    {
        return $this->id_folowers;
    }

    public function setIdFolowers(?int $id_folowers): self
    {
        $this->id_folowers = $id_folowers;

        return $this;
    }

    public function getIdSubscription(): ?int
    {
        return $this->id_subscription;
    }

    public function setIdSubscription(?int $id_subscription): self
    {
        $this->id_subscription = $id_subscription;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * @return Collection|post[]
     */
    public function getPost(): Collection
    {
        return $this->post;
    }

    public function addPost(post $post): self
    {
        if (!$this->post->contains($post)) {
            $this->post[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(post $post): self
    {
        if ($this->post->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|followers[]
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    public function addFollower(followers $follower): self
    {
        if (!$this->followers->contains($follower)) {
            $this->followers[] = $follower;
            $follower->setUser($this);
        }

        return $this;
    }

    public function removeFollower(followers $follower): self
    {
        if ($this->followers->removeElement($follower)) {
            // set the owning side to null (unless already changed)
            if ($follower->getUser() === $this) {
                $follower->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SavedPost[]
     */
    public function getSavedPost(): Collection
    {
        return $this->saved_post;
    }

    public function addSavedPost(SavedPost $savedPost): self
    {
        if (!$this->saved_post->contains($savedPost)) {
            $this->saved_post[] = $savedPost;
            $savedPost->setUser($this);
        }

        return $this;
    }

    public function removeSavedPost(SavedPost $savedPost): self
    {
        if ($this->saved_post->removeElement($savedPost)) {
            // set the owning side to null (unless already changed)
            if ($savedPost->getUser() === $this) {
                $savedPost->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Subscription[]
     */
    public function getSubscription(): Collection
    {
        return $this->subscription;
    }

    public function addSubscription(Subscription $subscription): self
    {
        if (!$this->subscription->contains($subscription)) {
            $this->subscription[] = $subscription;
            $subscription->setUser($this);
        }

        return $this;
    }

    public function removeSubscription(Subscription $subscription): self
    {
        if ($this->subscription->removeElement($subscription)) {
            // set the owning side to null (unless already changed)
            if ($subscription->getUser() === $this) {
                $subscription->setUser(null);
            }
        }

        return $this;
    }

    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    public function setDob(\DateTimeInterface $dob): self
    {
        $this->dob = $dob;

        return $this;
    }
}
